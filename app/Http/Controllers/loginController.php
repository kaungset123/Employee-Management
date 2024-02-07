<?php

namespace App\Http\Controllers;

class loginController extends Controller
{
    public function index(){
        return redirect('users/login');
    }
}
