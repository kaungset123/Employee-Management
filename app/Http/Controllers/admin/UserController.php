<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(){
        $dpmts = Department::all();
        return view('admin/user/create',compact('dpmts'));
    }
}
