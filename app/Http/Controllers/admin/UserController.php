<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('admin.user.all',compact('users'));
    }
    
    public function create(){
        $dpmts = Department::all();
        return view('admin/user/create',compact('dpmts'));
    }

    public function edit(){
        return view('admin.user.edit');
    }
}
