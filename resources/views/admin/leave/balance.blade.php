@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card-body" id="all_emp_tb">
        <h4 style="font-weight: bold;" class="mt-3 mb-4 text-info">{{ $data['header'] }}</h4>
        <form class="d-flex col-md-8 offset-md-2" action="{{ route('leave.balance',['perPage' => $data['leaves']->perPage()]) }}" method="GET">
            <a href="{{ route('leave.balance', ['perPage' => $data['leaves']->perPage()]) }}" style="color: black;">
                <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
            </a>
            @csrf
            <input class="form-control border-info" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
            <input class="form-control border-info" type="text" name="department_name" value="{{ $data['departmentName'] }}" placeholder="Search by department" aria-label="Search">
            <input type="number" class="form-control border-info" name="year" placeholder="search by year" value="{{ $data['created'] }}" min="2023" max="2050">
            <button class="btn btn-outline-info " type="submit">Search</button>
        </form>
        <div class="">
            @include('layout.pageLimit')
        </div>
        @if(count($data['leaveCounts']) > 0)
            <table class="table table-hover table-bordered mt-4">
                <thead>
                    <tr class="text-center">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Total</th>
                        <th>Annual Leave</th>
                        <th>Other Leave</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['leaveCounts'] as $leave)
                    <tr class="text-center">
                        <td>
                            <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $leave->user->img) }}">
                        </td>
                        <td>{{ $leave->user->name}}</td>
                        <td>
                            @if($leave->user->department != null) 
                                {{ $leave->user->department->name}}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $leave->total_count }}</td>
                        <td>{{ $leave->annual_leave }}</td>
                        <td>{{ $leave->other_leave }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h4 class="text-center text-danger">No leave balance result!</h4>
        @endif
        <div id="pagination">
            {{ $data['leaves']->links() }}
        </div>
    </div>
</div>

@endsection