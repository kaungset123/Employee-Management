<?php

namespace App\Http\Controllers\manager;

use App\Constants\LeaveRequestStatus;
use App\Events\RequestAccepted;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\RequestRejected;

class RequestController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Leave Request',
            'header' => 'LEAVE REQUEST',
        ];
    }

    public function index(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];

        $user = User::findOrFail(auth()->user()->id);
        $department_id = $user->department->id;
        $department = Department::findOrFail($department_id);
        // dd($department);
        // there will many user_id in userIds
        $user_id = $department->users->pluck('id')->toArray();
        // dd($userIds);
        // will fetcht only the user who exist in leave table 
        $leaveQuery = Leave::whereIn('user_id', $user_id)->where('status','0')->with('user');

        if ($query) {
            $leaveQuery->whereHas('user', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            });
        }

        if($created_at){
            $leaveQuery->whereDate('created_at',$created_at);
        }

        $perPage = $request->input('perPage');
        $leaves = $leaveQuery->paginate($perPage)->withQueryString();

        $this->data['leaves'] = $leaves;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;

        return view('manager.leave.index')->with(['data' => $this->data]);
    }

    public function accept(int $id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = LeaveRequestStatus::ACCEPTED;
        $leave->save();
        // RequestAccepted::dispatch($leave);
        return back()->with('status','leave accepted successfully');
    }

    public function reject(int $id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = LeaveRequestStatus::REJECTED;
        $leave->save();
        // RequestRejected::dispatch($leave);
        return back()->with('status','leave rejected successfully');
    }

    private function checkPermission($permission,$data = null ) {
        return $this->authorize($permission,$data);
    }
}
