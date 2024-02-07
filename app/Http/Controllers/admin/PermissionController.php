<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function create()
    {
        $permissions = Permission::get();
        return view('admin.permission.create',compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=> 'required'
        ]);
        Permission::create($validated);
        return redirect('admin/role/index')->with('status','new permission added successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('status','permission deleted');
    }
}
