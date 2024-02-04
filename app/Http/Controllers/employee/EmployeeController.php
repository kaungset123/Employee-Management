<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

use function App\Helpers\calculateAverageRating;

class EmployeeController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'My Department ',
            'header' => 'My Department',
        ];
    }

    public function index(Request $request)
    {
        
        $query = $request['search'];
        $created_at = $request['created_at'];

        $user = auth()->user();
        $department = Department::findOrFail($user->department->id);
        $userQuery = User::where('department_id',$department->id);
        // dd($users);
        if($query){
            $userQuery->where('name', 'like', "%$query%");
        }

        if($created_at){
            $userQuery->whereDate('created_at',$created_at);
        }
        
        // dd($users);
        $perPage = $request->input('perPage',10);
        $users = $userQuery->paginate($perPage)->withQueryString();

        $rating = [];
        foreach($users as $member){
            $rating[] = calculateAverageRating($member->id);
        }
        $this->data['users'] = $users;
        $this->data['rating'] = $rating;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        return view('employee.dashboard')->with(['data' => $this->data]);
    }

    private function checkPermission($permission,$data = null ) 
    {
        return $this->authorize($permission,$data);
    }

}
