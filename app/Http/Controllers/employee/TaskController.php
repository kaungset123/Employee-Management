<?php

namespace App\Http\Controllers\employee;

use Exception;
use App\Models\Task;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskAssignRequest;
use function App\Helpers\taskDeadLine;
use App\Constants\TaskStatus;
use App\Events\TaskCreate;
use App\Http\Requests\TaskAssignEditRequest;
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
        $this->checkPermission('task view');

        $query = $request['search'];

        $tasksQuery = Task::select('id','name','description','start_date','end_date','project_id','user_id','status')->where('project_id',$project_id)->with('user');

        if($query) {
            $tasksQuery->whereHas('user', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            });
        }

        $perPage = $request->input('perPage');
        $tasks = $tasksQuery->paginate($perPage)->withQueryString();

        foreach ($tasks as $task) {
            $deadlineWarning = taskDeadLine($task->project_id, $task->user_id);
            $task->deadlineWarning = $deadlineWarning;
        }

        $this->data['project_id'] = $project_id;
        $this->data['tasks'] = $tasks;
        $this->data['search'] = $query;
        return view('employee.task.index')->with(['data' => $this->data]);
    }

    public function create(int $id)
    {
        $this->checkPermission('task create',$id);

        $project = Project::findOrFail($id); 
        $this->data['title'] = 'Assign Task'; 
        $this->data['header'] = 'TASK ASSIGNING';
        $this->data['project'] = $project;
        return view('employee.task.create')->with(['data' => $this->data]);         
    }

    public function store(TaskAssignRequest $request)
    {
        $this->checkPermission('task create');

        $project_id = $request->project_id;

            $task =  Task::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'project_id' => $request->input('project_id'),
                'user_id' => $request->input('user_id'),
                'start_date' =>$request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'created_by' => $request->input('created_by')
            ]);

            TaskCreate::dispatch($task);

            return redirect()->route('task.index',['id' => $project_id])->with('status','task assigned successfully');     
    }

    public function edit(int $id)
    {
        $this->checkPermission('task update',$id);

        try {
            $task = Task::where('id',$id)->select('id','project_id','name','description','start_date','end_date','project_id','user_id','status','created_by')->first();

            $project = Project::findOrFail($task->project_id);
            $this->data['task'] = $task;
            $this->data['project'] = $project;
            $this->data['title'] = 'Edit Task';
            $this->data['header'] = 'TASK EDITION';
            return view('employee.task.edit')->with(['data' => $this->data]);
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }  
    }

    public function update(TaskAssignEditRequest $request,int $id)
    {
        $this->checkPermission('task update',$id);

        try{
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
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }    
    }

    public function deleteList(Request $request,int $project_id)
    {
        $query = $request['search'];

        $tasksQuery = Task::onlyTrashed()->select('id','name','description','start_date','end_date','project_id','user_id','status')->where('project_id',$project_id)->with('user');

        if($query) {
            $tasksQuery->whereHas('user', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            });
        }

        $perPage = $request->input('perPage',5);
        $tasks = $tasksQuery->paginate($perPage)->withQueryString();

        $this->data['header'] = 'Deleted Task List';
        $this->data['project_id'] = $project_id;
        $this->data['tasks'] = $tasks;
        $this->data['search'] = $query;
        return view('employee.task.deleteList')->with(['data' => $this->data]);
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
        $this->checkPermission('task delete',$id);

        try{
            $task=Task::findOrFail($id);    
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

    public function restore(int $id)
    {
        $this->checkPermission('task restore',$id); 

        try{
            $project_id = Task::onlyTrashed()->where('id',$id)->pluck('project_id')->first();
            $task=Task::onlyTrashed()->find($id);    
            $task->restore();
            return redirect()->route('task.index',['id' => $project_id])->with('status','Task restored successfully');  
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
        $this->checkPermission('task delete',$id);

        try{
            $task=Task::onlyTrashed()->find($id);    
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
