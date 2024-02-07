<?php

namespace App\Http\Controllers\hr;

use Exception;
use App\Events\AttendanceCreate;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

use Illuminate\Http\Request;

use function App\Helpers\overtimeCalculation;

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

        $user = auth()->user();
        $users = $user->department->users;

        $attendQuery = Attendance::whereIn('user_id', $users->pluck('id'))->with('user');

        if ($query) {
            $attendQuery->whereHas('user', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            });
        }
        
        if ($created_at) {
            $attendQuery->whereDate('date', $created_at);
        }

        $perPage = $request->input('perPage',10);
        $members = $attendQuery->paginate($perPage)->withQueryString();

        $this->data['attendances'] = $members;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;

        return view('hr.attendance.index')->with(['data' => $this->data]);
    }

    public function create(int $id)
    {   
        $this->checkPermission('attendance create');

        $today = Carbon::today();

        $user = User::select('id','name')->where('id',$id)->first();
        $userAttendance = Attendance::where('user_id',$id)->whereDate('created_at',$today)->first();
        
        if($userAttendance != null) {
            return back()->with('fail_status','You already made attendance for this staff today!');
        }else {
            $this->data['user'] = $user;
            $this->data['header'] = 'CREATE ATTENDANCE';
            return view('hr.attendance.create')->with(['data' => $this->data]);
        }
    }

    public function store(AttendanceRequest $request)
    {
        $this->checkPermission('attendance create');

        try {
            $created_by = auth()->user()->id;

            $clock_in = $request->clock_in;
            $clock_out = $request->clock_out;

            $overTime = overtimeCalculation($clock_in,$clock_out);

            $attendance =  Attendance::create([
                'date' => $request->input('date'),
                'user_id' => $request->input('user_id'), 
                'clock_in' => $clock_in,
                'clock_out' => $clock_out,
                'overtime' => $overTime,
                'created_by' => $created_by          
            ]);
            AttendanceCreate::dispatch($attendance);
            return redirect('hr/attendance/index')->with('status','Attendance submitted successfully!');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $this->checkPermission('attendance update');

        try {
            $attendance = Attendance::findOrFail($id);

            $this->data['attendance'] = $attendance;
            $this->data['title'] = 'Attendance Edit';
            $this->data['header'] = 'ATTENDANCE EDIT';
            return view('hr.attendance.edit')->with(['data' => $this->data]);
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }   
    }

    public function update(AttendanceRequest $request, int $id)
    {
        $this->checkPermission('attendance update');

        try {
            $attendance = Attendance::findOrFail($id);
            $updated_by = auth()->user()->id;
    
            $clock_in = $request->clock_in;
            $clock_out = $request->clock_out;
    
            $overTime = overtimeCalculation($clock_in,$clock_out);
            
            $attendance->update([
                'date' => $request->input('date'),
                'user_id' => $request->input('user_id'), 
                'clock_in' => $clock_in,
                'clock_out' => $clock_out,
                'overtime' => $overTime,
                'created_by' => $updated_by    
            ]);
    
            return redirect('hr/attendance/index')->with('status','attendance edited successfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }      
    }

    public function pdfGenerate(Request $request, $userId) 
    {
        $hr = auth()->user();
        $user_id = $request->input('id');
        $staff = User::findOrFail($user_id);
        $released_date = Carbon::now();

        $choseMonth = $request->input('month');
        $choseYear = $request->input('year');

        $attendances = Attendance::where('user_id', $user_id)
        ->whereYear('created_at', $choseYear)
        ->whereMonth('created_at', $choseMonth)
        ->get();
        
        if($attendances->isEmpty()) {
            return response()->json(['status' => 'failed', 'message' => 'There is no attendance-data for this year and month!']);
        }else {
            $data = [
                'released_date' => $released_date,
                'hr' => $hr,
                'staff' => $staff,
                'title' => 'Attendance Data',
                'attendances' => $attendances
            ];
            
            $pdf = app('dompdf.wrapper');

            $pdf->loadView('hr.attendance.pdf', $data)->setOptions(['defaultFont' => 'sans-serif']);

            return $pdf->download("{$staff->name}.ems.pdf");

        }
    }

    private function checkPermission($permission,$data = null ) 
    {
        return $this->authorize($permission,$data);
    }
}
