
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
                                <h4 style="font-weight: bold;" class="mt-3">LEAVE BALANCE</h4>
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Previous Year</th>
                                        <th>Current Year</th>
                                        <th>Total</th>
                                        <th>Accepted</th>
                                        <th>Rejected</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><img src=""></td>
                                        <td>Tiger Nixon</td>
                                        <td>10</td>
                                        <td>6</td>
                                        <td>16</td>
                                        <td>13</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td><img src=""></td>
                                        <td>Tiger Nixon</td>
                                        <td>10</td>
                                        <td>6</td>
                                        <td>16</td>
                                        <td>13</td>
                                        <td>3</td>
                                    </tr> 
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Previous Year</th>
                                        <th>Current Year</th>
                                        <th>Total</th>
                                        <th>Accepted</th>
                                        <th>Rejected</th>
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
    



