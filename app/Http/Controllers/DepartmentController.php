<?php

namespace App\Http\Controllers;

use App\Models\User;

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
        $users = User::select('id','img','name')->where('department_id',$id)->get();
        $members = [];
        foreach($users as $user){
            $members[] = calculateAverageRating($user->id);
        }

        $this->data['members'] = $members;
        return view('admin.department.index')->with(['data' => $this->data]);
    }
}
