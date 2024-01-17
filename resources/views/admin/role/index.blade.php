@extends("layout.master")
@section("title",$data['title'])

@section('content')
        <div class="app-main__outer mt-5 col-md-10 offset-md-1">
            @include('layout.flashmessage')
            <h3 class="text-center mb-5">All Role</h3>
            <table class="table">
                    <thead class="text-center">
                        <th>Role</th>
                        <th>Guard</th>
                        <th>Action</th>
                    </thead>
                    <tbody>     
                        @foreach($data['roles'] as $role)             
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
                        @endforeach
                    </tbody>
                </table>
        </div>
@endsection