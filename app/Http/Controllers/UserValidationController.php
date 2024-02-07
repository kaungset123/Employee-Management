<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserValidationController extends Controller
{

    public function login(){
       return view('auth.login');
    }

    public function store(Request $request)
    {
        dd($request);
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'phone' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'basic_salary' => 'required',
            'ot_rate' => 'required',
            'hourly_rate' => 'required',
            'password' => 'required|confirmed|min:6',
            'department_id' => 'required'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if($request->hasFile('img')){
            $validated['img'] = $request->file('img')->store('uploads','public');
        }
 
        $user = User::create($validated);

        $user->syncRoles($request->input('role'));

        auth()->login($user);

        return back()->with('status','A new user created successfully');
    }

    public function authenticate(Request $request) 
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();
            $user = auth()->user();
            return redirect('dashboard');
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
    
}
