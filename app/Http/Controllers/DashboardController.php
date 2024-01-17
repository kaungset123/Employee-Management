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

    public function __invoke(Request $request){
        $user = Auth::user();
        $this->data['active'] = 'project';

        switch ($user->getRoleNames()->first()) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with(['data' => $this->data]);
                break;
    
            case 'manager':
                return redirect()->route('manager.dashboard');
                break;

            case 'HR':
                return redirect()->route('hr.dashboard');
                break;
                
            case 'employee':
                return redirect()->route('employee.dashboard');
                break;
            // Add more cases as needed
    
            default:
                return redirect()->route('user.dashboard');
        }        
    }

    public function index(Request $request){
        $user = Auth::user();
        $this->data['active'] = 'project';

        switch ($user->getRoleNames()->first()) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with(['data' => $this->data]);
                break;
    
            case 'manager':
                return redirect()->route('manager.dashboard');
                break;

            case 'HR':
                return redirect()->route('hr.dashboard');
                break;
                
            case 'employee':
                return redirect()->route('employee.dashboard');
                break;
            // Add more cases as needed
    
            default:
                return redirect()->route('user.dashboard');
        }  
    }
}
