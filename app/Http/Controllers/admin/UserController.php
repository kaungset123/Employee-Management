<?php

namespace App\Http\Controllers\admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\imgChecker;
use function App\Helpers\imgExtension;
use function App\Helpers\userSearchbar;

class UserController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'All User ',
            'header' => 'User List',
        ];
    }

    public function index(Request $request)
    {  
        $this->checkPermission('user view');

        $query = $request['search'];
        $created_at = $request['created_at'];
        $department_name = $request['department_name'];

        $perPage = $request->input('perPage',10);
        $usersQuery = userSearchbar($query,$department_name,$created_at);
        $users = $usersQuery->paginate($perPage)->withQueryString();
        
        $this->data['users'] = $users;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        $this->data['departmentName'] = $department_name;

        return view('admin.employee.index')->with(['data' => $this->data]);      
    }

    public function create()
    {       
        $this->checkPermission('user create');

        try {
            $roles = Role::select('id','name')->get();
            $departments = Department::select('id','name')->get();

            $this->data['title'] = 'Create User';
            $this->data['departments'] = $departments;
            $this->data['roles'] = $roles;

            return view('admin/employee/create')->with(['data' => $this->data] );
        }
         catch(ModelNotFoundException $e) {
            return back()->with('status',$e->getMessage());
        }
        catch(\Exception $e){
            return back()->with('status',$e->getMessage());
        }
    }

    public function store(RegistrationRequest $request)
    {
        $this->checkPermission('user create');
        // dd($request);
        try{
            $created_by = auth()->user()->id;
            // dd($created_by); 
            $img = " " ;
            $imgFile = $request->file('img');
            $img = imgExtension($imgFile);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'date_of_birth' => $request->input('date_of_birth'),
                'password' => $request->input('password'),
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'basic_salary' => $request->input('basic_salary'),
                'ot_rate' => $request->input('ot_rate'),
                'hourly_rate' => $request->input('hourly_rate'),
                'department_id' => $request->input('department_id'),
                'responsible_dpt_id' => $request->input('responsible_dpt_id'),
                'img' => $img,
                'created_by' => $created_by ,
            ]);

            $user->syncRoles($request->input('role'));
            $user->save();
            
            return redirect('admin/user')->with('status','A new user created successfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('status',$e->getMessage());
        }
        catch(\Exception $e){
            return back()->with('status',$e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $this->checkPermission('user update',$id);

        try{
            $user = User::findOrFail($id);
            $roleName = $user->getRoleNames()->toArray();
            $roles = Role::select('id','name')->get();

            $departments = Department::all();
            $this->data['title'] = 'Edit User';
            $this->data['header'] = 'EDIT USER';
            $this->data['roleName'] = $roleName;
            $this->data['user'] = $user;
            $this->data['roles'] = $roles;
            $this->data['departments'] = $departments;

            return view('admin.employee.edit')->with(['data' => $this->data]);
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function update(UserUpdateRequest $request,int $id)
    {
        $this->checkPermission('user update',$id);

        try{
            // dd($request);
            $user = User::findOrFail($id);
            $updated_by = auth()->user()->id;
            $old_img = $user->img;
            $imgFile = $request->file('img');

            $img = imgChecker($user,$imgFile,$old_img);

            $pass = '';
            if ($request->password == null) {
                $pass = $user->password;
            }else{               
                $pass = bcrypt($request->input('password'));
            }
             
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'basic_salary' => $request->input('basic_salary'),
                'ot_rate' => $request->input('ot_rate'),
                'hourly_rate' => $request->input('hourly_rate'),
                'department_id' => $request->input('department_id'),
                'password' => $pass,
                'img' => $img,
                'updated_by' => $updated_by,
            ]);
    
            $user->syncRoles($request->input('role'));
            
            return redirect('admin/user')->with('status','A  user updated successfully');
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
        $this->checkPermission('user delete',$id);

        try{
            $user=User::findOrFail($id);
            // dd($user); 
            $projects = $user->projects; 
            $status = false;  
            foreach($projects as $project){
                if($project->status == 1){
                    $status = true;
                }
            }
            if($status) {
                return back()->with('failstatus','you can\'t delete ,this employee\'s project is in progress');
            }else{
                // $salarys = $user->salarys;
                // foreach($salarys as $salary) {
                //     $salary->delete();
                // }
                // dd($salarys);
                $user->delete();
                return redirect('admin/user')->with('status','User deleted successfully');
            }          
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
        $this->checkPermission('user restore');

        try{
            $user = User::withTrashed()->find($id);
            $user->restore();
            if($user){
                return redirect('admin/user')->with('status','user restored successfully');
            }
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
        $this->checkPermission('user delete');

            $user = User::withTrashed()->find($id);
            $img = $user->img;
            // dd($img);
            if(!empty($img)){
                $img_path = public_path('storage/uploads/'. $img);
                if(file_exists($img_path)){
                     unlink($img_path);
                }                
            }
            $user->forceDelete();
            if($user){
                return redirect('admin/users')->with('status','user forced deleted successfully');
            }
     
        // dd($id);
       
    }

    private function checkPermission($permission,$data = null )
    {
        return $this->authorize($permission,$data);
    }
}
