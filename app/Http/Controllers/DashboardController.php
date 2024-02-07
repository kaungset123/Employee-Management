<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Role Management',
            'header' => 'Role List',
            'active' => 'role'
        ];
    }

    public function index(Request $request){
        $user = Auth::user();

        switch ($user->getRoleNames()->first()) {
            case 'super admin':
                return redirect()->route('superAdmin.dashboard');

            case 'admin':
                return redirect()->route('admin.dashboard');
   
            case 'manager':
                return redirect()->route('manager.dashboard');
    
            case 'HR':
                return redirect()->route('hr.dashboard');
  
            case 'employee':
                return redirect()->route('employee.dashboard');
        }  
    }
}
