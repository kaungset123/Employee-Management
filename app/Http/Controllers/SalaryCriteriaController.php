<?php

namespace App\Http\Controllers;

use App\Models\SalaryCriteria;
use Illuminate\Http\Request;

class SalaryCriteriaController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'SalaryCriteria Management',
            'header' => 'Salary Criteria'
        ];
    }

    public function index() {
        $this->checkPermission('payrollcriteria update');
        
        $criterias = SalaryCriteria::select('id','rating_point','bonus_amount')->get();
        $this->data['criterias'] = $criterias;
        return view('admin.salarycriteria.index')->with(['data' => $this->data]);
    }

    public function update(Request $request,int $id)
    {
        $this->checkPermission('payrollcriteria update',$id);
        // dd($id);
        $criteria = SalaryCriteria::findOrFail($id);
        // dd($criteria);
        // $amount = $request->input('amount');
        // dd($amount);
        $validated = $request->validate([
            'bonus_amount' => 'required'
        ]);
        // dd($validated);
        $success = $criteria->update($validated);

        if($success) {
            return response()->json(['status' => 'success', 'message' => 'A salary criteria is updated successfully!']);
        }else {
            return response()->json(['failed' => 'failed', 'message' => 'department edition  failed !']);
        } 
    }

    private function checkPermission($permission,$data = null) 
    {
        return $this->authorize($permission,$data);
    }
}
