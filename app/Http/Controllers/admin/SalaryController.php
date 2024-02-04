<?php

namespace App\Http\Controllers\admin;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryDetail;
use function App\Helpers\salarySearchbar;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class SalaryController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Salary Management',
            'header' => 'Salary List',
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        $this->checkPermission('payroll view');
         
        $query = $request['search'];
        $created_at = $request['created_at'];
        $department_name = $request['department_name'];

        $salaryQuery = SalaryDetail::select('id','ot_time','ot_amount','leave','dedution','salary','bonus','user_id','created_at','net_salary')
                        ->with(['user' => function ($query) {
                            $query->select('id', 'name', 'img', 'department_id');
                        }]);
        
        $perPage = $request->input('perPage',10);
        $salarys = salarySearchbar($salaryQuery, $query, $department_name, $created_at);
        $salarys = $salarys->paginate($perPage)->withQueryString();

        $this->data['header'] = 'All Salary List';
        $this->data['salarys'] = $salarys;
        $this->data['search'] = $query;
        $this->data['departmentName'] = $department_name;
        $this->data['created'] = $created_at;
        return view('admin.salary.index')->with(['data' => $this->data]);
    }

    public function deleteList(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];
        $department_name = $request['department_name'];

        $salaryQuery = SalaryDetail::onlyTrashed()->select('id','ot_time','ot_amount','leave','dedution','salary','bonus','user_id','created_at','net_salary')
                        ->with(['user' => function ($query) {
                            $query->select('id', 'name', 'img', 'department_id');
                        }]);
        
        $perPage = $request->input('perPage',10);
        $salarys = salarySearchbar($salaryQuery, $query, $department_name, $created_at);
        $salarys = $salarys->paginate($perPage)->withQueryString();

        $this->data['header'] = 'Deleted Salary List';
        $this->data['salarys'] = $salarys;
        $this->data['search'] = $query;
        $this->data['departmentName'] = $department_name;
        $this->data['created'] = $created_at;
        return view('admin.salary.deleteList')->with(['data' => $this->data]);
    }

    public function destroy(int $id)
    {
        $this->checkPermission('payroll delete',$id);

        try {
            $salary = SalaryDetail::findOrFail($id);
            $salary->delete();
            return redirect('admin/salary')->with('status', 'salary is deleted sucessfully');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }  
  
    }

    public function restore(int $id)
    {
        $this->checkPermission('payroll delete',$id);

        $salary = SalaryDetail::onlyTrashed($id);
        $salary->restore();
        return redirect('/admin/salary')->with('status','salary record is restored successfully');
    }

    private function checkPermission($permission,$data = null ) 
    {
        return $this->authorize($permission,$data);
    }
}
