<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use function App\Helpers\calculateAverageRating;

use Illuminate\Http\Request;

class HrController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'HR Home',
            'header' => 'Department Members',
        ];
    }

    public function index(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];

        $user = auth()->user();
        $department = Department::findOrFail($user->department->id);
        $userQuery = User::where('department_id',$department->id);

        if($query){
            $userQuery->where('name', 'like', "%$query%");
        }

        if($created_at){
            $userQuery->whereDate('created_at',$created_at);
        }
        
        // dd($users);
        $perPage = $request->input('perPage',5);
        $users = $userQuery->paginate($perPage)->withQueryString();
        $rating = [];
        foreach($users as $member){
                $rating[] = calculateAverageRating($member->id);       
        }
        
        $this->data['users'] = $users;
        $this->data['rating'] = $rating;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        return view('hr.dashboard')->with(['data' => $this->data]);
    }
}
