<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function App\Helpers\admin_dash;

class SuperAdminController extends Controller
{
    //
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Admin Home',
            'header' => 'Project List',
        ];
    }

    public function index(){
       $status =  admin_dash();
    //    dd($status);
        $this->data['status'] = $status;
        return view('superadmin.dashboard')->with(['data' => $this->data]);
    }
}
