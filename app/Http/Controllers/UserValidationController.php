<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserValidationController extends Controller
{
    public function login(){
       return view('auth.login');
    }

    public function authenticate(Request $request) {
        // dd($request);
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();
            $user = auth()->user();
            return redirect('admin/dashboard');
            // if($user->hasRole("Admin")){
            //     return redirect('admin')->with('status', 'You are now logged in!');
            // }else{
            //     return redirect('/')->with('status', 'You are now logged in!');
            // }
        }

        // return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
