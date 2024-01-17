@extends("layout.master")
@section("title","Employee Home")

@section('content')
<div class="app-main__outer">
    <div class="card-body" id="all_emp_tb">
        <h4 style="font-weight: bold;" class="mb-3">{{$data['header']}}</h4>
        @if(session('status'))
            <p class="alert alert-success text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show">
                {{session('status')}}
            </p>
        @endif
        @if(session('failstatus'))
            <p class="alert alert-danger text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show">
                {{session('failstatus')}}
            </p>
        @endif
        <form class="d-flex col-md-8 offset-md-2" action="{{ route('employee.dashboard') }}" method="GET">
            @csrf
            <a href="{{ route('employee.dashboard', ['perPage' => $data['users']->perPage()]) }}" style="color: black;">
                <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
            </a>
            <input type="hidden" name="perPage" value="{{ $data['users']->perPage() }}">
            <input class="form-control me-2" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
            <input type="date" class="form-control" name="created_at" value="{{ $data['created'] }}">
            <button class="btn btn-outline-success " type="submit">Search</button>
        </form>
        <div class="">
            @include('layout.pageLimit')
        </div>
        @if(count($data['rating']) > 0)
            <table style="width: 100%;" class="table table-hover table-bordered mt-4 ">
                <thead class="text-center">
                    <th>Image</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Current Rating</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($data['rating'] as $member)
                    <tr class="text-center">
                        <td>
                            @if($member['user']->img !== '' && !empty($member['user']->img))
                            <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $member['user']->img)}}">
                            @else
                            no image
                            @endif
                        </td>
                        <td>{{ $member['user']->name }}</td>
                        <td>{{ $member['user']->getRoleNames()->first() }}</td>
                        <td>{{ $member['user']->email }}</td>
                        <td>{{ $member['rating'] }}</td>
                        <td class="">
                            <a href="{{ route('rating.index',$member['user']->id) }}" class="text-success" style="text-decoration:none;"> Rate Here</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3 class="text-danger text-center mt-5">no match result</h3>
        @endif
        <div id="pagination">
            {{ $data['users']->links() }}
        </div>
    </div>
</div>

@endsection