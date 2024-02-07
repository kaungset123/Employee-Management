<?php

namespace App\Http\Controllers\admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use function App\Helpers\calculateAverageRating;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class DepartmentController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Department Management',
            'header' => 'Department List',
        ];
    }

    public function index()
    {
        $this->checkPermission('department view');

        $departments = Department::withTrashed()->select('id','name','deleted_at')->get();

        $this->data['departments'] = $departments;
        return view('admin.department.index')->with(['data' => $this->data]);
    }

    public function store(Request $request)
    {
        $this->checkPermission('department create');

        $validated = $request->validate([
            'name' => 'required'
        ]);

        $department = Department::create($validated);
       
        if($department) {
            return response()->json(['status' => 'success', 'message' => 'A department is created successfully!']);
        }else {
            return response()->json(['failed' => 'failed', 'message' => 'department creation  failed !']);

        }
    }

    public function update(Request $request, int $id)
    {
        $this->checkPermission('department update');
        try {
            $department = Department::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required'
            ]);
            $dept = $department->update($validated);

            if($dept) {
                return response()->json(['status' => 'success', 'message' => 'A department is edited successfully!']);
            }else {
                return response()->json(['failed' => 'failed', 'message' => 'department edition  failed !']);
            }   
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function show(int $id)
    {
        $this->checkPermission('department view');

        $department = Department::findOrFail($id);
        $users = User::select('id','img','name')->where('department_id',$id)->get();
        $members = [];
        foreach($users as $user){
            $members[] = calculateAverageRating($user->id);
        }
        $this->data['department'] = $department;
        $this->data['members'] = $members;
        return view('admin.department.show')->with(['data' => $this->data]);
    }

    public function destroy(int $id)
    {
        $this->checkPermission('department delete');

        try {
            $department = Department::findOrFail($id);
            $count = $department->users->count();

            if($count > 0){
                return back()->with('fail_status','Empty this department first!');
            }else {
                $department->delete();
                return back()->with('status','department deleted successfully');
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
        $this->checkPermission('department delete');
        
        try {
            $department = Department::withTrashed()->find($id);
            $department->forceDelete();
            return back()->with('status','department permanently deleted successfully');
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
        $this->checkPermission('department restore');

        try {
            $department = Department::withTrashed($id);
            $department->restore();
            return back()->with('status','department restore successfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    private function checkPermission($permission,$data = null) 
    {
        return $this->authorize($permission,$data);
    }
}
