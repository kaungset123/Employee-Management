@extends("layout.master")
@section("title","Admin Home")

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.necess')
    <div class="app-main p-0">
            @include('layout.sidebar')
            <div class="app-main__outer">
               <div class="card mb-3">
                            <div class="card-body" id="all_emp_tb">
                                <h4 style="font-weight: bold;">ALL EMPLOYEE</h4>
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Start date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td><img src=""></td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->department->name}}</td>
                                                <td>{{$user->phone}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->created_at}}</td>
                                                <td>
                                                    <a href="/admin/users/edit">
                                                    <i class="fa fa-pencil-square-o text-primary" aria-hidden="true" style="font-size: 17px;"></i>
                                                    <a>
                                                    <i class="fa fa-trash text-danger" aria-hidden="true" style="font-size: 17px;"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Start date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                </div>
            </div> 
        </div>
    </div>
</div>

@include('layout.app_drawer_wrapper')

@endsection
    



