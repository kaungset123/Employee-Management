<?php

namespace App\Http\Controllers;

use function App\Helpers\admin_dash;

class AdminController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'All Project',
            'header' => 'Project List',
        ];
    }

    public function index(){
       $status =  admin_dash();
        $this->data['status'] = $status;
        return view('admin.dashboard')->with(['data' => $this->data]);
    }
}
