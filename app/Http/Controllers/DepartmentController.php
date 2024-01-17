<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

use function App\Helpers\calculateAverageRating;

class DepartmentController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Department',
        ];
    }

    public function index(int $id)
    {
        // $department = Department::findOrFail($id);
        $users = User::select('id','img','name')->where('department_id',$id)->get();
        $members = [];
        foreach($users as $user){
            $members[] = calculateAverageRating($user->id);
        }
        // dd($members);
        $this->data['members'] = $members;
        return view('admin.department.index')->with(['data' => $this->data]);
    }
}
