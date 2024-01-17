<?php

namespace App\Http\Controllers\employee;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\RequestCreate;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveRequest;
use App\Http\Controllers\Controller;
use App\Models\Leave;
use function App\Helpers\leaveLimitCalculation;
use function App\Helpers\leaveBalanceQuery;

class LeaveController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Leave Request',
            'header' => 'LEAVE REQUEST',
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $created_at = $request['created_at'];

        $user_id = auth()->user()->id;
        $leavesQuery = Leave::withTrashed()->select('id','name','user_id','start_date','end_date','total_days','created_at','status')->where('user_id',$user_id)->with('user');

        if($created_at){
            $leavesQuery->whereDate('created_at',$created_at);
        }

        $perPage = $request->input('perPage',10);
        $leaves = $leavesQuery->paginate($perPage);

        $this->data['header'] = 'My Leave Request';
        $this->data['created'] = $created_at;
        $this->data['leaves'] = $leaves;
        return view('employee.leave.index')->with(['data' => $this->data]); 
    }

    public function create()
    {
        $this->checkPermission('leave create'); 

        return view('employee.leave.create')->with(['data' => $this->data]);
    }

    public function store(LeaveRequest $request)
    {
        $this->checkPermission('leave create'); 

        try {
            $user_id = $request->user_id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $half_day = $request->is_half_day;
           
            $limitTotalDay = leaveLimitCalculation( $user_id,$start_date, $end_date,$half_day );
     
            $totalNewDay = $limitTotalDay['totalNewDay'];
    
            if($limitTotalDay['limitTotalDay'] > 10 && $request->input('name') == 'annual leave'){
                return back()->with('failstatus','your annual leave limit is already used');
            }else{
                $leave = Leave::create([
                'name' => $request->input('name'),
                'user_id' => $request->input('user_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'total_days' => $totalNewDay
                ]);
                // RequestCreate::dispatch($leave);
                return back()->with('status','leave request sumitted sucessfully');
            }  
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }   
       
    }

    public function balance(int $id)
    {

    }

    private function checkPermission($permission,$data = null )
    {
        return $this->authorize($permission,$data);
    }
}
