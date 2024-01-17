<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

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
    //    dd($status);
        $this->data['status'] = $status;
        return view('admin.dashboard')->with(['data' => $this->data]);
    }
}
