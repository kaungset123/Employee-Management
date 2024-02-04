@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
        <div class="card-body" id="all_emp_tb">
            <div class="">
                @include('layout.flashmessage')
            </div>
            <b style="font-size: 23px;" class="mt-4 text-info">{{ $data['header'] }}</b>
            <form class="d-flex col-md-8 offset-md-2 mt-3" action="{{ route('request.index') }}" method="GET">
                @csrf
                <a href="{{ route('request.index',['perPage' => $data['leaves']->perPage()]) }}" style="color: black;">
                    <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                </a>
                <input type="hidden" name="perPage" value="{{ $data['leaves']->perPage() }}">
                <input class="form-control border-info" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
                <input type="date" class="form-control border-info" name="created_at" value="{{ $data['created'] }}">
                <button class="btn btn-outline-info " type="submit">Search</button>
            </form>
            @include('layout.pageLimit')
            @if(count($data['leaves']) > 0)
                <table style="width: 100%;"  class="table table-hover table-striped table-bordered mt-4 ">
                    <thead class="text-center">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total Days</th>
                        <th>Status</th>
                        @if(auth()->user()->hasRole('manager'))
                            <th>Action</th>
                        @endif
                        <tbody>
                            @foreach($data['leaves'] as $leave)
                                @if($leave->user->id != auth()->user()->id)
                                    <tr class="text-center">
                                        <td>
                                            <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('/storage/uploads/' . $leave->user->img) }}">
                                        </td>
                                        <td>{{ $leave->user->name }}</td>
                                        <td>{{ $leave->name }}</td>
                                        <td>{{ $leave->start_date->format('F j, Y') }}</td>
                                        <td>{{ $leave->end_date->format('F j, Y') }}</td>
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
                                            <div class="mt-2">
                                                @if($leave->status == 0)
                                                <p class="text-primary" > pending </p>
                                                @endif
                                            </div>
                                        </td>
                                        @if(auth()->user()->hasRole('manager'))
                                            <td class="p-0">
                                                <div class="nav-item dropdown p-1 ">
                                                    <a class="nav-link dropdown-toggle text-black ms-4" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                                                        <!-- <i class="fa fa-ellipsis-v" aria-hidden="true"></i> -->
                                                    </a>
                                                    <ul id="action_drop" class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item text-black" >
                                                                <form action="{{ route('request.accept',$leave->id) }}" method="post">
                                                                    @csrf
                                                                    @method('PUT')                                               
                                                                    <button type="submit" class="text-success" style="border:none;background:none;">
                                                                        Accept
                                                                    </button>
                                                                </form>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-black" >
                                                                <form action="{{ route('request.reject',$leave->id) }}" method="post">
                                                                    @csrf
                                                                    @method('PUT')                                               
                                                                    <button type="submit" class="text-danger" style="border:none;background:none;" >
                                                                        Reject
                                                                    </button>
                                                                </form>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>                                               
                                            </td>  
                                        @endif                                     
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            @else
                <h4 class="text-center text-danger mt-5">no leave request!</h4>
            @endif
            <div id="pagination">
                {{ $data['leaves']->links() }}
            </div>
        </div>
    </div>
@endsection