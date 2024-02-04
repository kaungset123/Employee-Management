@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card-body" id="all_leave_tb">
        @include('layout.flashmessage')
        <h4 style="font-weight: bold;" class="mt-3 text-info">{{$data['header']}}</h4>
        <form class="d-flex col-md-8 offset-md-2" action="{{ route('leave.index') }}" method="GET">
            <a href="{{ route('leave.index', ['perPage' => $data['leaves']->perPage()]) }}" style="color: black;">
                <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
            </a>
            <input type="hidden" name="perPage" value="{{ $data['leaves']->perPage() }}">
            @include('layout.searchbar')
        </form>
        <div class="mt-3" style="position: relative;">
            @include('layout.pageLimit')
            <div class="" style="position: absolute;right:1rem;top:5px;">
                <a href="{{ route('leave.deleteList') }}" id="project_delete_list">
                    @include('component.deleteButton')                   
                </a>
            </div>
        </div>
        @if(count($data['leaves']) > 0 )
        <table style="width: 100%;" class="table table-hover table-bordered mt-4">
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
                        <td><img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('/storage/uploads/' . $leave->user->img) }}"></td>
                        <td>{{$leave->user->name}}</td>
                        <td>{{$leave->user->department->name}}</td>
                        <td>{{$leave->name}}</td>
                        <td>{{$leave->start_date->format('F j, Y ')}}</td>
                        <td>{{$leave->end_date->format('F j, Y ')}}</td>
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
                            @if($leave->status != 0)
                            <!-- <a class="dropdown-item text-black"> -->
                            <form method="post" action="{{ route('leave.destroy',$leave->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border:none;cursor:pointer;background:none;" class=" text-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                                    Delete
                                </button>
                            </form>
                            <!-- </a> -->
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <h4 class="text-danger text-center mt-5">no leave request!</h4>
        @endif
        <div id="paginagtion">
            {{ $data['leaves']->links() }}
        </div>
    </div>
</div>
@endsection