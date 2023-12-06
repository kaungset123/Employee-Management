@extends("layout.master")
@section("title","Admin Home")

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.necess')
    <div class="app-main p-0">
        @include('layout.sidebar')
        <div class="app-main__outer">
            <div class="card mb-3">
                <div class="card-body" id="all_leave_tb">
                    <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered mt-4">
                        <h4 style="font-weight: bold;" class="mt-4">LEAVE REQUEST</h4>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Total Day</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src=""></td>
                                <td>Tiger Nixon</td>
                                <td>annual Leave</td>
                                <td>04/06/2023</td>
                                <td>06/06/2023</td>
                                <td>3</td>
                                <td>
                                    <button class="btn btn-sm">Pending</button>
                                </td>
                                <td>
                                    <div class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-black" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                                            <!-- <i class="fa fa-ellipsis-v" aria-hidden="true"></i> -->
                                        </a>
                                        <ul id="action_drop" class="dropdown-menu">
                                                <li><a class="dropdown-item text-black" href="">Accept</a></li>
                                                <li><a class="dropdown-item text-black" href="">Reject</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><img src=""></td>
                                <td>Tiger Nixon</td>
                                <td>annual Leave</td>
                                <td>04/06/2023</td>
                                <td>06/06/2023</td>
                                <td>3</td>
                                <td>
                                    <button class="btn btn-sm">Pending</button>
                                </td>
                                <td>
                                    <div  class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-black" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                                            <!-- <i class="fa fa-ellipsis-v" aria-hidden="true"></i> -->
                                        </a>
                                        <ul id="action_drop" class="dropdown-menu">
                                                <li><a class="dropdown-item text-black" href="">Accept</a></li>
                                                <li><a class="dropdown-item text-black" href="">Reject</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Total Day</th>
                                <th>Status</th>
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