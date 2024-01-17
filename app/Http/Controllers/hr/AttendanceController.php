<?php

namespace App\Http\Controllers\hr;

use App\Events\AttendanceCreate;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

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
        $query = $request['search'];
        $created_at = $request['created_at'];

        $user = auth()->user();
        $users = $user->department->users;

        //dd($users);
        $attendQuery = Attendance::whereIn('user_id', $users->pluck('id'))->with('user');
        // dd($attendQuery);
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

        //dd($members);
        $this->data['attendances'] = $members;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;

        return view('hr.attendance.index')->with(['data' => $this->data]);
    }

    public function create(int $id)
    {
        $this->checkPermission('attendance create');

        $user = User::select('id','name')->where('id',$id)->first();
        $this->data['user'] = $user;
        $this->data['header'] = 'Create Attendance';
        return view('hr.attendance.create')->with(['data' => $this->data]);
    }

    public function store(AttendanceRequest $request)
    {
        $this->checkPermission('attendance create');

        try {
            // dd($request);
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
            // AttendanceCreate::dispatch($attendance);
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
            // dd($attendance);
            $this->data['attendance'] = $attendance;
            $this->data['title'] = 'Attendance Edit';
            $this->data['header'] = 'Attendance Edit';
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
    
            return redirect('attendance/index')->with('status','attendance edited successfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }

       
    }

    private function checkPermission($permission,$data = null ) 
    {
        return $this->authorize($permission,$data);
    }
}
