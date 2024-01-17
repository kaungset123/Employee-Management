<?php

namespace App\Http\Controllers\hr;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Events\SalaryCreate;
use App\Models\SalaryDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function App\Helpers\salaryCalculation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SalaryController extends Controller
{
    public  $data = [];
    
    public function __construct()
    {
        $this->data = [
            'title' => 'Salary Management',
            'header' => 'Salary Calculation ',
        ];
    }

    public function index(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];

        $user = auth()->user();
        $users = $user->department->users;

        //dd($users);
        $salaryQuery = SalaryDetail::whereIn('user_id', $users->pluck('id'))->with('user');
        // dd($salaryQuery);
        if($query){
            $salaryQuery->whereHas('user', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            }); 
        }

        if ($created_at) {
            $salaryQuery->whereDate('created_at', $created_at);
        }

        $perPage = $request->input('perPage');
        $salarys = $salaryQuery->paginate($perPage)->withQueryString();
        // dd($salarys);
        $this->data['header'] = 'DEPARTMENT SALARY'; 
        $this->data['salarys'] = $salarys;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        return view('hr.salary.index')->with(['data' => $this->data]);
    }

    public function create(int $id)
    {
        $user = User::select('id','name','img','basic_salary','ot_rate','hourly_rate')->where('id',$id)->first();
        // dd($user);
        $date = Carbon::now();
        $salary = salaryCalculation($id,$date);

        $this->data['header'] = 'salary detail';
        $this->data['salary'] = $salary;
        $this->data['user'] = $user;
        return view('hr.salary.create')->with(['data' => $this->data]);
    }

    public function pdfGenerate(int $id)
    {
        $user = User::select('id', 'name','basic_salary', 'ot_rate', 'hourly_rate')->where('id', $id)->first();
        $date = Carbon::now();
        $salary = salaryCalculation($id, $date);

        $data = [
            'title' => 'salary detail',
            'date' => Carbon::now(),
            'user' => $user,
            'salary' => $salary,
        ];

        $pdf = app('dompdf.wrapper');

        // Pass the data directly to the loadView method
        $pdf->loadView('hr.salary.pdf', $data)->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download('webappfix.pdf');
    }
    public function show()
    {

    }
    public function store(int $id)
    {  
        try {
            $this->checkPermission('payroll create');
      
            $date = Carbon::now();
    
            $user = User::select('id')->where('id',$id)->first();
    
            $salarys = salaryCalculation($user->id,$date);
            // dd($salarys);
            $salary = SalaryDetail::create($salarys);
            SalaryCreate::dispatch($salary);
            
            // dd($salary);
            return back()->with('status','salary calculated successfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
       
    }

    private function checkPermission($permission,$data = null ) {
        return $this->authorize($permission,$data);
    }
}

