<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use function App\Helpers\imgChecker;


class ProfileController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Profile Management',
            'header' => 'Edit Profile',
        ];
    }

    public function edit(int $id)
    {
        $user = User::select('id','name','email','phone','address','password','img','date_of_birth')->where('id',$id)->first();
        // dd($user); 
        $this->data['user'] = $user;
        return view('employee.profile.edit')->with(['data' => $this->data]);
    }

    public function update(ProfileUpdateRequest $request,int $id)
    {
        // dd($request);
        $user = User::findOrFail($id);
        $updated_by = auth()->user()->id;
        $old_img = $user->img;
        $imgFile = $request->file('img');
        $img = imgChecker($user,$imgFile,$old_img);

        $pass = '';
        if ($request->password == null) {
            $pass = $user->password;
        }else{               
            $pass = bcrypt($request->input('password'));
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'date_of_birth' => $request->input('date_of_birth'),
            'address' => $request->input('address'),
            'password' => $pass,
            'img' => $img,
            'updated_by' => $updated_by,
        ]);
        return back()->with('status','profile updated successfully');
    }
}
