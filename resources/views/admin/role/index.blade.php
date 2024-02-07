@extends("layout.master")
@section("title",$data['title'])

@section('content')
        <div class="app-main__outer mt-4 col-md-10 offset-md-1" >
            @include('layout.flash_message')
            <b class="mb-5 text-info" style="font-size:30px;">All Roles</b>
            <table class="table">
                    <thead class="text-center">
                        <th>Role</th>
                        <th>Guard</th>
                        <th>Action</th>
                    </thead>
                    <tbody>     
                        @foreach($data['roles'] as $role) 
                            @if(auth()->user()->getRoleNames()->first() != 'super admin')  
                                @if($role->name != 'super admin' && $role->name != 'admin')      
                                    <tr class="text-center" style="line-height: 30px;">
                                        <td>{{$role->name}}</td>
                                        <td>{{$role->guard_name}}</td>
                                        <td class="">
                                            <div class="">
                                                <a href="{{route('role.permission',$role->id)}}" style="text-decoration: none;">
                                                    <b>Edit </b>  
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr class="text-center" style="line-height: 30px;">
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->guard_name}}</td>
                                    <td class="">
                                        <div class="">
                                            <a href="{{route('role.permission',$role->id)}}" style="text-decoration: none;">
                                                <b>Edit </b>  
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
        </div>
@endsection