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
        $this->checkPermission('payroll view');

        $query = $request['search'];
        $created_at = $request['created_at'];

        $user = auth()->user();
        $users = $user->department->users;

        $salaryQuery = SalaryDetail::whereIn('user_id', $users->pluck('id'))->with('user');

        if($query){
            $salaryQuery->whereHas('user', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            }); 
        }

        if ($created_at) {
            $salaryQuery->whereDate('created_at', $created_at);
        }

        $perPage = $request->input('perPage');
        $salaries = $salaryQuery->paginate($perPage)->withQueryString();

        $this->data['header'] = 'Department Salary'; 
        $this->data['salaries'] = $salaries;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        return view('hr.salary.index')->with(['data' => $this->data]);
    }

    public function create(int $id)
    {
        $this->checkPermission('payroll create',$id);

        $date = Carbon::today();
        $salary = SalaryDetail::where('user_id',$id)->whereDate('created_at',$date)->first();

        if($salary){
            return redirect('hr/dashboard')->with('fail_status','This staff\'s salary is created for this month');
        }else{
            $user = User::select('id','name','img','basic_salary','ot_rate','hourly_rate')->where('id',$id)->first();
            $date = Carbon::now();
            $salary = salaryCalculation($id,$date);
    
            $this->data['header'] = 'salary detail';
            $this->data['salary'] = $salary;
            $this->data['user'] = $user;
            return view('hr.salary.create')->with(['data' => $this->data]);
        }
    }

    public function pdfGenerate(int $id)
    {
        $user = User::select('id', 'name','basic_salary', 'ot_rate', 'hourly_rate','department_id')->where('id', $id)->first();
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

        return $pdf->download('ems.pdf');
    }

    public function store(int $id)
    {  
        try {
            $this->checkPermission('payroll create');
      
            $date = Carbon::now();

            $user = User::select('id')->where('id',$id)->first();
    
            $salaries = salaryCalculation($user->id,$date);

            $salary = SalaryDetail::create($salaries);
            SalaryCreate::dispatch($salary);

            return redirect('hr/dashboard')->with('status','salary calculated successfully');
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

