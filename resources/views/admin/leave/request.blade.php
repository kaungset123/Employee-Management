@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <!-- <div class="card mb-3 "> -->
    <div class="card-body" id="all_emp_tb">
        <h4 style="font-weight: bold;" class="mt-3 mb-4 text-info">{{ $data['header'] }}</h4>
        <form class="d-flex col-md-8 offset-md-2" action="{{ route('leave.manager') }}" method="GET">
            <a href="{{ route('leave.manager', ['perPage' => $data['leaves']->perPage()]) }}" style="color: black;">
                <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
            </a>
            <input type="hidden" name="perPage" value="{{ $data['leaves']->perPage() }}">
            @include('layout.searchbar')
        </form>
        <div class="">
            @include('layout.pageLimit')
        </div>
        @if(count($data['leaves']) > 0)
            <table class="table table-hover table-striped table-bordered mt-4">
                <thead>
                    <tr class="text-center">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Total Day</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['leaves'] as $leave)
                        <tr class="text-center">
                            <td>
                                <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $leave->user->img) }}">
                            </td>
                            <td>{{ $leave->user->name}}</td>
                            <td>{{ $leave->user->department->name}}</td>
                            <td>{{ $leave->name }}</td>
                            <td>{{ $leave->start_date->format('F y, j')}}</td>
                            <td>{{ $leave->end_date->format('F y, j')}}</td>
                            <td>
                                @if($leave->total_days == 0.5)
                                half day
                                @elseif($leave->total_days == 1)
                                1 day
                                @else
                                {{ $leave->total_days }} days
                                @endif
                            </td>
                            <td>
                                <div class="mt-3">
                                    @if($leave->status == 0)
                                    <p class="text-primary"> Pending</p>
                                    @elseif($leave->status == 1)
                                    <p class="text-success"> Accepted</p>
                                    @else
                                    <p class="text-danger"> Rejected</p>
                                    @endif
                                </div>                               
                            </td>
                            <td>
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-black" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <!-- <i class="fa fa-ellipsis-v" aria-hidden="true"></i> -->
                                    </a>
                                    <ul id="action_drop" class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-black">
                                                <form action="{{ route('leave.accept',$leave->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-success" style="border:none;background:none;">
                                                        Accept
                                                    </button>
                                                </form>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-black">
                                                <form action="{{ route('leave.reject',$leave->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-danger" style="border:none;background:none;">
                                                        Reject
                                                    </button>
                                                </form>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h4 class="text-danger text-center mt-5">no leave request!</h4>
        @endif
        <div id="pagination">
            {{ $data['leaves']->links() }}
        </div>
    </div>
    <!-- </div> -->
</div>
@endsection