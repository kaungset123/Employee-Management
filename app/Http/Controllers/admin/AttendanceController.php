<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

use function App\Helpers\attendanceSearchbar;

class AttendanceController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Attendance Management',
            'header' => 'Attendance List',
        ];
    }

    public function index(Request $request)
    {       
        $query = $request['search'];
        $created_at = $request['created_at'];
        $department_name = $request['department_name'];

        $attendanceQuery = Attendance::select('id','user_id','date','clock_in','clock_out','overtime','created_at')->with(['user']);
        // dd($attendanceQuery);
        $perPage = $request->input('perPage',10);
        $attendances = attendanceSearchbar($attendanceQuery,$query,$department_name,$created_at);
        $attendances = $attendances->paginate($perPage)->withQueryString();

        $this->data['attendances'] = $attendances;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        $this->data['departmentName'] = $department_name;
        return view('admin.attendance.index')->with(['data' => $this->data]);
    }

    public function destroy(int $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return back()->with('status','attendance record deleted successfully');
    }
}
