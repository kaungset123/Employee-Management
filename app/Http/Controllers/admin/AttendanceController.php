<?php

namespace App\Http\Controllers\admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $this->checkPermission('attendance view');
              
        $query = $request['search'];
        $created_at = $request['created_at'];
        $department_name = $request['department_name'];

        $attendanceQuery = Attendance::select('id','user_id','date','clock_in','clock_out','overtime','created_at')->with(['user']);

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
        $this->checkPermission('attendance delete',$id);

        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();
            return back()->with('status','attendance record deleted successfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function deleteList(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];
        $department_name = $request['department_name'];

        $attendanceQuery = Attendance::onlyTrashed()->select('id','user_id','date','clock_in','clock_out','overtime','created_at')->with(['user']);

        $perPage = $request->input('perPage',10);
        $attendances = attendanceSearchbar($attendanceQuery,$query,$department_name,$created_at);
        $attendances = $attendances->paginate($perPage)->withQueryString();

        $this->data['attendances'] = $attendances;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        $this->data['departmentName'] = $department_name;
        $this->data['header'] = 'Deleted Attendance List';
        return view('admin.attendance.deleteList')->with(['data' => $this->data]);
    }

    public function restore(int $id)
    {
        $this->checkPermission('attendance restore',$id);

        try {
            $attendance = Attendance::withTrashed()->where('id',$id)->first();
            $attendance->restore();
            return redirect('admin/attendance/index')->with('status','attendance record restored successfully');
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
