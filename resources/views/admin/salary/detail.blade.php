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
                                <h4 style="font-weight: bold;">EMPLOYEE SALARY</h4>
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Employee ID</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Salary</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><img src=""></td>
                                        <td>Tiger Nixon</td>
                                        <td>DEV-2020-0021</td>
                                        <td>nixon@gmail.com</td>
                                        <td>Development</td>
                                        <td>$320,800</td>
                                        <td>
                                            <i class="fa fa-pencil-square-o text-primary" aria-hidden="true" style="font-size: 17px;" ></i>
                                            <i class="fa fa-trash text-danger" aria-hidden="true" style="font-size: 17px;" ></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src=""></td>
                                        <td>Tiger Nixon</td>
                                        <td>FEDEV-2020-0005</td>
                                        <td>nixon@gmail.com</td>
                                        <td>Development</td>
                                        <td>$320,800</td>
                                        <td>
                                            <i class="fa fa-pencil-square-o text-primary " aria-hidden="true" style="font-size: 17px;"></i>
                                            <i class="fa fa-trash text-danger" aria-hidden="true" style="font-size: 17px;"></i>
                                        </td>
                                    </tr> 
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                    <th>Image</th>
                                        <th>Name</th>
                                        <th>Employee ID</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Salary</th>
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
    



