@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <!-- <div class="card mb-3 "> -->
    <div class="card-body" id="all_emp_tb">
        <h4 style="font-weight: bold;" class="mt-3 mb-4">{{ $data['header'] }}</h4>
        <form class="d-flex col-md-8 offset-md-2" action="{{ route('leave.balance',['perPage' => $data['leaves']->perPage()]) }}" method="GET">
            <a href="{{ route('leave.balance', ['perPage' => $data['leaves']->perPage()]) }}" style="color: black;">
                <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
            </a>
            @include('layout.searchbar')
        </form>
        <div class="pagination-form mb-3" onclick="togglePaginationOptions()">
            <div class="choosePaginate mb-1">
                 Page Limit
            </div> 
            <div class="pagination-options" >
                <a class="pagination-option" onclick="changePerPage(5)">5</a>
                <a class="pagination-option" onclick="changePerPage(10)">10</a>
                <a class="pagination-option" onclick="changePerPage(15)">15</a>
            </div>
        </div>
        <table class="table table-hover table-striped table-bordered mt-4">
            <thead>
                <tr class="text-center">
                    <th>Image</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Total</th>
                    <th>Annual Leave</th>
                    <th>Other Leave</th>
                    <th>Accepted</th>
                    <th>Rejected</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['leaveCounts'] as $leave)
                <tr class="text-center">
                    <td>
                        <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $leave->user->img) }}">
                    </td>
                    <td>{{ $leave->user->name}}</td>
                    <td>{{ $leave->user->department->name}}</td>
                    <td>{{ $leave->total_count }}</td>
                    <td>{{ $leave->annual_leave }}</td>
                    <td>{{ $leave->other_leave }}</td>
                    <td>{{ $leave->accepted_count}}</td>
                    <td>{{ $leave->rejected_count}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="pagination">
            {{ $data['leaves']->links() }}
        </div>
    </div>
    <!-- </div> -->
</div>

@endsection