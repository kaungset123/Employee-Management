<?php

namespace App\Http\Controllers\admin;

use App\Events\ProjectCreate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use function App\Helpers\calculateProgress;
use function App\Helpers\calculatProjectProgress;
use function App\Helpers\projectSearchbar;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ProjectController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'All Project',
            'header' => 'Project List',
        ];
    }

    public function index(Request $request)
    {    
        $query = $request['search'];
        $created_at = $request['created_at'];
        $member_name = $request['member_name'];

        $projectQuery = Project::select('id','start_date','end_date','status','name','project_manager_id')
                      ->with(['members','members.department']);
                    
        $projectProgress = projectSearchbar($query,$member_name,$created_at,$projectQuery);


        $perPage = $request->input('perPage',4);
        $projects = $projectProgress->paginate($perPage)->withQueryString(); 
    
        $projectProgress = [];
        foreach($projects as $project){
            $projectProgress[$project->id] = calculatProjectProgress($project->id);
        }

        $this->data['search'] = $query;
        $this->data['memberName'] = $member_name;
        $this->data['created'] = $created_at;
        $this->data['projects'] = $projects;
        $this->data['projectProgress'] = $projectProgress;
        return view('admin.project.index')->with(['data' => $this->data]);
    }

    public function progress(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];
        $member_name = $request['member_name'];

        $projectQuery = Project::select('id','start_date','end_date','status','name','project_manager_id')
        ->where('status',1)
        ->with(['members','members.department']);
               
        $projectProgress = projectSearchbar($query,$member_name,$created_at,$projectQuery);

        $perPage = $request->input('perPage',4);
        $projects = $projectProgress->paginate($perPage)->withQueryString(); 
        
        $projectProgress = [];
        foreach($projects as $project){
            $projectProgress[$project->id] = calculatProjectProgress($project->id);
        }

        $this->data['search'] = $query;
        $this->data['memberName'] = $member_name;
        $this->data['created'] = $created_at;
        $this->data['title'] = 'Running Projects';
        $this->data['projects'] = $projects;
        $this->data['projectProgress'] = $projectProgress;
        return view('admin.project.progress')->with(['data' => $this->data]);
    }

    public function complete(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];
        $member_name = $request['member_name'];

        $projectQuery = Project::select('id','start_date','end_date','status','name','project_manager_id')
                    ->where('status',3)
                    ->with(['members','members.department']);

        $projectProgress = projectSearchbar($query,$member_name,$created_at,$projectQuery);

        $perPage = $request->input('perPage',4);
        $projects = $projectProgress->paginate($perPage)->withQueryString(); 
        
        $projectProgress = [];
        foreach($projects as $project){
            $projectProgress[$project->id] = calculatProjectProgress($project->id);
        }

        $this->data['search'] = $query;
        $this->data['memberName'] = $member_name;
        $this->data['created'] = $created_at;
        $this->data['projectProgress'] = $projectProgress;
        $this->data['title'] = 'Completed Projects';
        $this->data['projects'] = $projects;
        return view('admin.project.completed')->with(['data' => $this->data]); 
    }

    public function create()
    {
        $this->checkPermission('project create');

        // omitting the user who taking part in two running projects
        $users = User::whereDoesntHave('projects', function ($query) {
            $query->where('status', 1) && 
            $query->groupBy('user_id')
            ->havingRaw('COUNT(user_id) > 1'); 
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'HR');
        })->get();

        // dd($users);  
        $this->data['users'] = $users;
        $this->data['header'] = 'Create Project';
        $this->data['title'] = 'Project Create';
        return view('admin.project.create')->with(['data' => $this->data]);
    }

    public function store(ProjectRequest $request)
    {
        $this->checkPermission('project create');

       $project = Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => $request->input('status'),
            'project_manager_id' => $request->input('project_manager_id'),
        ]); 

        $project->members()->attach($request->input('project_manager_id'));
        $team_members = $request->input('members');
        foreach($team_members as $team_member){
           $project->members()->attach($team_member);
        }

        // ProjectCreate::dispatch($project);

        return redirect('admin/project')->with('status','Project created successfully');
    }

    public function edit(int $id)
    {
        $this->checkPermission('project update',$id);

        $project = Project::findOrFail($id);
        // dd($project);
        $user = User::select('id','name')->get();
        $this->data['users'] = $user;
        $this->data['project'] = $project;
        $this->data['title'] = 'Project Edit';
        $this->data['header'] = 'EDIT PROJECT';
        return view('admin.project.edit')->with(['data' => $this->data]);
    }


    public function update(ProjectRequest $request,int $id)
    {
        $this->checkPermission('project update',$id);
        
        try{
            $project = Project::findOrFail($id);
    
            $project->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'status' => $request->input('status'),
                'project_manager_id' => $request->input('project_manager_id'),
            ]);
    
            // ProjectCreate::dispatch($project);
        
            $teamMembers = $request->input('members', []);
    
            // Include the project manager ID in the array of team members
            $teamMembers[] = $request->input('project_manager_id');
        
            // Sync both project manager and team members in a single call
            $project->members()->sync($teamMembers);
        
            return redirect('admin/project')->with('status', 'Project updated successfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
        
    }

    public function destroy(int $id)
    {
        $this->checkPermission('project delete',$id);

        try{
            $project = Project::findOrFail($id);
            $tasks = Task::where('project_id',$id)->get();
            // dd($tasks);
            foreach($tasks as $task){
                $task->delete();
            }
            $project->delete();
            // $project->members()->detach($id);
            return redirect('admin/project')->with('status','Project deleted successfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
       
    }

    public function deleteList()
    {
        $projects = Project::onlyTrashed()->get();
        // dd($projects);
        $this->data['projects'] = $projects;
        $this->data['title'] = 'Deleted List';
        $this->data['header'] = 'DELETED LISTS';
        return view('admin.project.restore')->with(['data' => $this->data]);
    }

    public function restore(int $id)
    {
        $this->checkPermission('project restore',$id);

        try{
        $project = Project::withTrashed()->findOrFail($id);
        $tasks = Task::withTrashed()->where('project_id', $id)->get();
        // dd($tasks);
        foreach($tasks as $task){
            $task->restore();
        }
        $project->restore();
        // $project->members()->attach($project->project_manager_id);
        return redirect('admin/project')->with('status','Project restore successfully');
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
        $this->checkPermission('project delete',$id);

            $project = Project::withTrashed()->find($id);
            // dd($project);
            $tasks = Task::withTrashed()->where('project_id',$id)->get();
            // dd($tasks);
            foreach($tasks as $task){
                $task->forceDelete();
            }

            $project->members()->detach();

            $project->forceDelete();

            return redirect('admin/project/index')->with('status', 'Project permanently deleted successfully');
 
    }
    
    private function checkPermission($permission,$data = null ) {
        return $this->authorize($permission,$data);
    }
}
