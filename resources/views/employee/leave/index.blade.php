@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card-body" id="all_leave_tb">
        <h4 style="font-weight: bold;" class="mt-3">{{$data['header']}}</h4>
        <form class="d-flex col-md-8 offset-md-2 mt-3" action="{{ route('user.leave.index') }}" method="GET">
            @csrf
            <a href="{{ route('user.leave.index',['perPage' => $data['leaves']->perPage()]) }}" style="color: black;">
                <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
            </a>
            <input type="hidden" name="perPage" value="{{ $data['leaves']->perPage() }}">
            <input type="date" class="form-control" name="created_at" value="{{ $data['created'] }}">
            <button class="btn btn-outline-success " type="submit">Search</button>
        </form>
        <div class="">
            @include('layout.pageLimit')
        </div>
        <table style="width: 100%;" class="table table-hover  table-bordered mt-4">
            @if(count($data['leaves']) > 0 )
                <thead>
                    <tr class="text-center">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Total Day</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['leaves'] as $leave)
                    <tr class="text-center">
                        <td><img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('/storage/uploads/' . $leave->user->img) }}"></td>
                        <td>{{$leave->user->name}}</td>
                        <td>{{$leave->name}}</td>
                        <td>{{$leave->start_date->format('F j, Y')}}</td>
                        <td>{{$leave->end_date->format('F j, Y') }}</td>
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
                                    <p class="text-primary"> Pending</p>
                                @elseif($leave->status == 1)
                                    <p class="text-success"> Accepted</p>
                                @else
                                    <p class="text-danger"> Rejected</p>
                                @endif
                            </div>                         
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @else
                <h4 class="text-danger text-center mt-5">no leave!</h4>
            @endif
        </table>
        <div id="paginagtion">
           {{ $data['leaves']->links() }}
        </div>
    </div>
</div>
@endsection