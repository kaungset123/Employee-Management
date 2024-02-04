<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\SalaryDetail;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public  $data = [];
    
    public function __construct()
    {
        $this->data = [
            'title' => 'Salary Management',
            'header' => 'My Salary',
        ];
    }

    public function index(Request $request)
    {
        $this->checkPermission('payroll view');

        $created_at = $request['created_at'];

        $salaryQuery = SalaryDetail::where('user_id',auth()->user()->id)->with('user');

        if ($created_at) {
            $salaryQuery->whereDate('created_at', $created_at);
        }

        $perPage = $request->input('perPage',10);
        $salarys = $salaryQuery->paginate($perPage)->withQueryString();

        $this->data['salarys'] = $salarys;
        $this->data['created'] = $created_at;
        return view('employee.salary.index')->with(['data' => $this->data]);
    }

    private function checkPermission($permission,$data = null ) {
        return $this->authorize($permission,$data);
    }
}
