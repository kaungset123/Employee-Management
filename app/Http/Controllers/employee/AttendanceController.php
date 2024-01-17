<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Attendance Management',
            'header' => 'My Attendance List',
        ];
    }

    public function index(Request $request)
    {
        $this->checkPermission('attendance view');

        $created_at = $request['created_at'];

        $attendanceQuery = Attendance::select('date','clock_in','clock_out','overtime','user_id')->where('user_id',auth()->user()->id);

        if($created_at){
            $attendanceQuery->whereDate('date',$created_at);
        }

        $perPage = $request->input('perPage',10);
        $attendances = $attendanceQuery->paginate($perPage)->withQueryString();

        $this->data['attendances'] = $attendances;
        $this->data['created'] = $created_at;
        return view('employee.attendance.index')->with(['data' => $this->data]);
    }

    private function checkPermission($permission,$data = null ) 
    {
        return $this->authorize($permission,$data);
    }
}
