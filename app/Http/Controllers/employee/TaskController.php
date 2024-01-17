<?php

namespace App\Http\Controllers\employee;

use Exception;
use App\Models\Task;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskAssignRequest;
use function App\Helpers\deadLineWarning;
use function App\Helpers\taskDeadLine;
use App\Constants\TaskStatus;
use App\Events\TaskCreate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Task Management',
            'header' => 'Task List',
        ];
    }

    public function index(int $project_id,Request $request)
    {
        $query = $request['search'];

        $tasksQuery = Task::select('id','name','description','start_date','end_date','project_id','user_id','status')->where('project_id',$project_id)->with('user');

        if($query) {
            $tasksQuery->whereHas('user', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            });
        }

        $perPage = $request->input('perPage');
        $tasks = $tasksQuery->paginate($perPage)->withQueryString();
        // dd($tasks);
        foreach ($tasks as $task) {
            $deadlineWarning = taskDeadLine($task->project_id, $task->user_id);
            $task->deadlineWarning = $deadlineWarning;
        }
        // dd($tasks);
        $this->data['project_id'] = $project_id;
        $this->data['tasks'] = $tasks;
        $this->data['search'] = $query;
        return view('employee.task.index')->with(['data' => $this->data]);
    }

    public function create(int $id)
    {
        $project = Project::findOrFail($id); 
        $this->data['title'] = 'Assign Task'; 
        $this->data['header'] = 'TASK ASSIGNING';
        $this->data['project'] = $project;
        return view('employee.task.create')->with(['data' => $this->data]);         
    }

    public function store(TaskAssignRequest $request)
    {
        $project_id = $request->project_id;

        $task =  Task::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'project_id' => $request->input('project_id'),
            'user_id' => $request->input('user_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'created_by' => $request->input('created_by')
        ]);

        // TaskCreate::dispatch($task);

        return redirect()->route('task.index',['id' => $project_id])->with('status','task assigned successfully');
    }

    public function edit(int $id)
    {
        $task = Task::where('id',$id)->select('id','project_id','name','description','start_date','end_date','project_id','user_id','status','created_by')->first();
        // dd($task->project_id);
        $project = Project::findOrFail($task->project_id);
        $this->data['task'] = $task;
        $this->data['project'] = $project;
        $this->data['title'] = 'Edit Task';
        $this->data['header'] = 'Task Edit Form';
        return view('employee.task.edit')->with(['data' => $this->data]);
    }

    public function update(TaskAssignRequest $request,int $id)
    {
        $task = Task::findOrFail($id);
        $project_id = $request->project_id;
        $task->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'project_id' => $request->input('project_id'),
            'user_id' => $request->input('user_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'created_by' => $request->input('created_by'),
            'updated_by' => $request->input('updated_by')
        ]);

        return redirect()->route('task.index',['id' => $project_id])->with('status','Task Updated successfully');
    }


    public function start(int $id)
    {
        $task = Task::findOrFail($id);
        $task->status = TaskStatus::IN_PROGRESS;
        $task->save();
        return back();
    }

    public function complete(int $id)
    {
        $task = Task::findOrFail($id);
        $task->status = TaskStatus::COMPLETED;
        $task->save();
        return back();
    }
    
    public function destroy(int $id)
    {
        try{
            $task=Task::findOrFail($id);    
            // dd($task);
            $task->delete();
            return back()->with('status','Task deleted successfully');  
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }  
    }

    public function force_delete(int $id)
    {
        try{
            $task=Task::withTrashed($id);    
            // dd($task);
            $task->forceDelete();
            return back()->with('status','Task force deleted successfully');  
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }   
    }
    private function checkPermission($permission,$data = null ) {
        return $this->authorize($permission,$data);
    }
}
