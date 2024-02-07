<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use function App\Helpers\admin_dash;

class SuperAdminController extends Controller
{
    //
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'SuperAdmin Home',
            'header' => 'Project List',
        ];
    }

    public function index(){
       $status =  admin_dash();

        $this->data['status'] = $status;
        return view('superAdmin.dashboard')->with(['data' => $this->data]);
    }
}
