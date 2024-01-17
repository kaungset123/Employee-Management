<?php

namespace App\Http\Controllers\employee;

use App\Constants\ProjectStatus;
use App\Constants\TaskStatus;
use App\Events\TaskCreate;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\DeadlockException;
use function App\Helpers\calculateProgress;
use function App\Helpers\calculatProjectProgress;
use function App\Helpers\deadLineWarning;
use function App\Helpers\projectSearchbar;

class ProjectController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'My Project',
            'header' => 'Project List',
        ];
    }

    public function index(Request $request)
    {
        $query = $request['search'];
        $member_name = $request['member_name'];
        $created_at = $request['created_at'];

        // dd($member_name);
        $user = User::findOrFail(auth()->user()->id);
        $projects = $user->projects;
        // dd($projects);

        $projectQuery = Project::whereIn('id', $projects->pluck('id'))->with('members');

        $projectQuery = projectSearchbar($query,$member_name,$created_at,$projectQuery);

        $perPage = $request->input('perPage',4);
        $projects = $projectQuery->paginate($perPage)->withQueryString();

        $projectProgress = [];
        foreach($projects as $project){
            $projectProgress[$project->id] = calculatProjectProgress($project->id);
        }

        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        $this->data['memberName'] = $member_name;
        $this->data['projectProgress'] = $projectProgress;  
        $this->data['projects'] = $projects;         
        return view('employee.project.project')->with(['data' => $this->data]);
    }

    public function complete(Request $request)
    {
        $query = $request['search'];
        $member_name = $request['member_name'];
        $created_at = $request['created_at'];

        $user = User::findOrFail(auth()->user()->id);
        $projects = $user->projects;

        $projectQuery = Project::whereIn('id', $projects->pluck('id'))->where('status',3)->with('members');

        $projectQuery = projectSearchbar($query,$member_name,$created_at,$projectQuery);

        $perPage = $request->input('perPage',4);
        $completed = $projectQuery->paginate($perPage)->withQueryString();
       
        // $this->data['completed'] = $completed;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        $this->data['memberName'] = $member_name;
        $this->data['completed'] = $completed; 
        $this->data['projects'] = $projects;         
        return view('employee.project.completed')->with(['data' => $this->data]);       
    }

    public function show(int $id)
    {
        $this->checkPermission('project view',$id);

        $project = Project::findOrFail($id);
        // dd($project);
        $users = $project->members;
        // dd($users);
        $taskProgress = [];
        $projectProgress = calculatProjectProgress($id);
        // dd($projectProgress);
        foreach($users as $user){
            $taskProgress[$user->id] = calculateProgress($user->id,$id);
        }
        // dd($taskProgress);
        $this->data['taskProgress'] = $taskProgress;
        $this->data['projectProgress'] = $projectProgress;
        $this->data['project'] = $project;
        $this->data['title'] = 'Project Detail';
        return view('employee.project.detail')->with(['data' => $this->data]);
    }

    public function task(int $project_id)
    {
        $user_id = auth()->user()->id;
        $tasks = Task::where(['project_id'=>$project_id,'user_id'=>$user_id])->get();
        foreach ($tasks as $task) {
            $deadlineWarning = deadLineWarning($task->project_id, $user_id);
            $task->deadlineWarning = $deadlineWarning;
        }
        
        $this->data['title'] = 'My Task';
        $this->data['header'] = 'MY TASK';
        $this->data['tasks'] = $tasks;
        return view('employee/project/mytask')->with(['data' => $this->data]);
    }

    public function start(int $id)
    {
        $project = Project::findOrFail($id);
        $task_count = Task::where('project_id',$id)->count();
        // dd($task_count);
        $member_count = $project->members->count();
        // dd($member_count);
        
        if($task_count >= $member_count){
            $project->status = ProjectStatus::IN_PROGRESS;
            $project->save();
            // TaskCreate::dispatch($project);
            return back()->with('status',"Your project is start!");
        }else {
            return back()->with('failstatus',"You can't start ! task assigning is not completed.");
        }
     
    }

    private function checkPermission($permission,$data = null ) {
        return $this->authorize($permission,$data);
    }
}
