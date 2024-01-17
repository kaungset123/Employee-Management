<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use function App\Helpers\calculateAverageRating;


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
        $departments = Department::withTrashed()->select('id','name','deleted_at')->get();
        // dd($departments);
        $this->data['departments'] = $departments;
        return view('admin.department.index')->with(['data' => $this->data]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        // dd($request->all());
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


    public function edit(int $id)
    {
    }

    public function update(Request $request, int $id)
    {
        // dd($id);
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

    public function show(int $id)
    {
        $department = Department::findOrFail($id);
        $users = User::select('id','img','name')->where('department_id',$id)->get();
        $members = [];
        foreach($users as $user){
            $members[] = calculateAverageRating($user->id);
        }
        // dd($members);
        $this->data['department'] = $department;
        $this->data['members'] = $members;
        return view('admin.department.show')->with(['data' => $this->data]);
    }

    public function destroy(int $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return back()->with('status','department deleted sucessfully');
    }

    public function force_delete(int $id)
    {
        $department = Department::withTrashed()->find($id);
        // dd($department);
        $department->forceDelete();
        return back()->with('status','department permanently deleted sucessfully');
    }

    public function restore(int $id)
    {
        $department = Department::withTrashed($id);
        // dd($department);
        $department->restore();
        return back()->with('status','department restore sucessfully');
    }
}
