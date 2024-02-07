<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class RoleController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Role Management',
            'header' => 'Role List',
        ];
    }

    public function index()
    {  
        $this->checkPermission('role view');

        $roles = Role::get();
        $this->data['roles'] = $roles;
        return view('admin.role.index')->with(['data' => $this->data]);      
    }

    public function edit(string $id)
    {
        $this->checkPermission('role update');

        try{
            $permissions = Permission::get();
            $this->data['permissions'] = $permissions;
            return view('admin.role.edit')->with(['data' => $this->data]);
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
        
    }

    public function permission(Role $role)
    {
        try{
            $roles = $role->permissions()->pluck('name')->toArray();
            $role = $role;
            $permissions = Permission::all()->pluck('name')->toArray();
            $groupedPermissions = [];

            foreach ($permissions as $permission) {
                $groupName = explode(' ', $permission)[0];
                $groupedPermissions[$groupName][] = $permission;
             }
             
             $this->data['roles'] = $roles;
             $this->data['role'] = $role;
             $this->data['groupedPermissions'] = $groupedPermissions;
    
            return view('admin.role.setpermission')->with(['data' => $this->data]);
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }

    }

    public function set_permission(Request $request,Role $role)
    {             
        try{
            $newPermissions = $request->input('permission', []);

            $role->syncPermissions($newPermissions);
        
            return redirect('admin/role/index')->with('status', 'Permissions updated successfully.');
        }
        catch(ModelNotFoundException $e){
            return back()->with('error',$e->getMessage());
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
       
    }

   private function checkPermission($permission,$data = null ) {
        return $this->authorize($permission,$data);
    } 

}
