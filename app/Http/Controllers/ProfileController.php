<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use function App\Helpers\imgChecker;
use function App\Helpers\calculateAverageRating;

class ProfileController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Profile Management',
            'header' => 'EDIT PROFILE',
        ];
    }

    public function index(int $id)
    {
        $this->checkPermission('profile view',$id);

        $user = calculateAverageRating($id);
        $this->data['user'] = $user;
        return view('employee.profile.index')->with(['data' => $this->data]);
    }

    public function edit(int $id)
    {
        $this->checkPermission('profile update',$id);

        $user = User::select('id','name','email','phone','address','password','img','date_of_birth')->where('id',$id)->first();
        // dd($user); 
        $this->data['user'] = $user;
        return view('employee.profile.edit')->with(['data' => $this->data]);
    }

    public function update(ProfileUpdateRequest $request,int $id)
    {
        $this->checkPermission('profile update',$id);

        $user = User::findOrFail($id);
        $updated_by = auth()->user()->id;
        $direct = auth()->user()->getRoleNames()->first();
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

        if($direct == 'super admin') {
            return redirect('superadmin/dashboard')->with('status','profile updated successfully');
        }elseif($direct == 'admin') {
            return redirect('admin/dashboard')->with('status','profile updated successfully');
        }elseif($direct == 'HR') {
            return redirect('hr/dashboard')->with('status','profile updated successfully');
        }else{
            return redirect('employee/dashboard')->with('status','profile updated successfully');
        }
}

    private function checkPermission($permission,$data = null ) 
    {
        return $this->authorize($permission,$data);
    }
}
