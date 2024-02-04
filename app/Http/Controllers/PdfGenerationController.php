<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class PdfGenerationController extends Controller
{
    public  $data = [];
    
    public function __construct()
    {
        $this->data = [
            'title' => 'PDF Management',
            'header' => 'PDF File',
        ];
    }

    public function index(Request $request)
    {
        $query = $request['search'];
        $created_at = $request['created_at'];

        $user = auth()->user();
        $department = Department::findOrFail($user->department->id);
        $userQuery = User::where('department_id',$department->id);

        if($query){
            $userQuery->where('name', 'like', "%$query%");
        }

        if($created_at){
            $userQuery->whereDate('created_at',$created_at);
        }
        
        // dd($users);
        $perPage = $request->input('perPage',5);
        $users = $userQuery->paginate($perPage)->withQueryString();
        // dd($users);

        $this->data['users'] = $users;
        $this->data['search'] = $query;
        $this->data['created'] = $created_at;
        return view('hr.pdfgenerate.index')->with(['data' => $this->data]);
    }

    private function checkPermission($permission,$data = null ) {
        return $this->authorize($permission,$data);
    }
}
