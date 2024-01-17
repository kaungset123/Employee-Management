<?php

namespace App\Http\Controllers\admin;

use App\Models\Leave;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Constants\LeaveRequestStatus;
use function App\Helpers\leaveSearchbar;
use function App\Helpers\leaveBalanceCount;
use function App\Helpers\leaveBalanceQuery;
use Carbon\Carbon;
use App\Events\RequestAccepted;
use App\Events\RequestRejected;

class LeaveRequestController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Leave Management',
            'header' => 'LEAVE LIST',
            'paginate' => 5,
        ];
    }

    public function index(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['year'];
        // $created_at = $request->validate([
        //     'created_at' => 'required|integer|min:2000|max:2100'
        // ]);
        $department_name = $request['department_name'];

        $leavesQuery = Leave::select('id', 'name', 'start_date', 'end_date', 'total_days', 'status', 'user_id')
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'img', 'department_id');
            }]);

        $perPage = $request->input('perPage',10);
        $leaves = leaveSearchbar($leavesQuery, $query, $department_name, $created_at);
        $leaves = $leaves->paginate($perPage)->withQueryString();

        $this->data['leaves'] = $leaves;
        $this->data['search'] = $query;
        $this->data['departmentName'] = $department_name;
        $this->data['created'] = $created_at;
        return view('admin.leave.index')->with(['data' => $this->data]);
    }

    public function balance(Request $request)
    {
        $query = $request->input('search');
        $created_at = $request['year'];
        $department_name = $request->input('department_name');

        // dd($request);

        $leavesQuery = Leave::with(['user', 'user.department']);  

        $leavesQuery = leaveSearchbar($leavesQuery, $query, $department_name, $created_at);
      
        // dd($leavesQuery);
        $user_ids = $leavesQuery->distinct('user_id')->pluck('user_id')->toArray();

        $perPage = $request->input('perPage');
        $leaves = leaveBalanceQuery($leavesQuery,$user_ids,$created_at);
        $leaves = $leaves->paginate($perPage)->withQueryString();
        $leaveCounts = [];

        foreach ($leaves as $leave) {
            $leaveCounts[] = leaveBalanceCount($leave->user_id,$created_at);
        }
        // dd($leaveCounts);
        $this->data['search'] = $query;
        $this->data['departmentName'] = $department_name;
        $this->data['created'] = $created_at;
        $this->data['leaves'] = $leaves;
        $this->data['leaveCounts'] = $leaveCounts;
        $this->data['header'] = 'Leave Balance';
        $this->data['title'] = 'Leave Balance';
        return view('admin.leave.balance')->with(['data' => $this->data]);
    }

    public function show(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];
        $department_name = $request['department_name'];

        $managerRole = Role::where('name', 'manager')->first();
        $userIdsWithManagerRole = $managerRole->users()->pluck('id')->toArray();
        // dd($userIdsWithManagerRole);

        $leavesQuery = Leave::select('id', 'name', 'start_date', 'end_date', 'total_days', 'status', 'user_id')
            ->whereIn('user_id', $userIdsWithManagerRole)
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'img', 'department_id');
            }]);

        $perPage = $request->input('perPage',5);
        $leaves = leaveSearchbar($leavesQuery, $query, $department_name, $created_at);
        $leaves = $leaves->paginate($perPage)->withQueryString();

        $this->data['title'] = 'Leave Request';
        $this->data['header'] = 'Manager Request';
        $this->data['search'] = $query;
        $this->data['departmentName'] = $department_name;
        $this->data['created'] = $created_at;
        $this->data['leaves'] = $leaves;
        return view('admin.leave.request')->with(['data' => $this->data]);
    }

    public function accept(int $id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = LeaveRequestStatus::ACCEPTED;
        $leave->save();
        // RequestAccepted::dispatch($leave);
        return back()->with('status', 'leave accepted successfully');
    }

    public function reject(int $id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = LeaveRequestStatus::REJECTED;
        $leave->save();
        // RequestRejected::dispatch($leave);
        return back()->with('status', 'leave rejected successfully');
    }
  
    public function destroy(int $id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();
        return back()->with('status','leave record deleted successfully!');
    }

    private function checkPermission($permission,$data = null ) 
    {
        return $this->authorize($permission,$data);
    }
}
