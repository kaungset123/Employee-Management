@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer ">
    <!-- <div class="card"> -->
        <div class="card-body bg-white" id="all_emp_tb">
            <div class="">
                @include('layout.flashmessage')
            </div>
            <h4 style="font-weight: bold;" class="mb-3 text-info">{{$data['header']}}</h4>
            <form class="d-flex col-md-8 offset-md-2 mt-4" action="{{ route('hr.dashboard') }}" method="GET">
                @csrf
                <a href="{{ route('hr.dashboard', ['perPage' => $data['users']->perPage()]) }}" style="color: black;">
                    <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                </a>
                <input type="hidden" name="perPage" value="{{ $data['users']->perPage() }}">
                <input class="form-control border-info" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
                <input type="date" class="form-control border-info" name="created_at" value="{{ $data['created'] }}">
                <button class="btn btn-outline-info " type="submit">Search</button>
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
                        <th>Start Date</th>
                        <th>Department</th>
                        <th>Email</th>
                        <th>Current Rating</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($data['rating'] as $member)
                            @foreach($member['user']->getRoleNames() as $role)
                                @if($role == 'manager')
                                    <tr class="text-center" style="height: 60px;">
                                        <td>
                                            @if($member['user']->img !== '' && !empty($member['user']->img))
                                            <a href="{{ route('profile.index',$member['user']->id) }}">
                                                <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $member['user']->img)}}">                                               
                                            </a>
                                            @else
                                            no image
                                            @endif
                                        </td>
                                        <td>{{ $member['user']->name }}</td>
                                        <td>
                                            @foreach($member['user']->getRoleNames() as $role)
                                                {{ $role }}
                                                @if(!$loop->last) 
                                                ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $member['user']->created_at->format('F j, Y') }}</td>
                                        <td>{{ $member['user']->department->name }}</td>
                                        <td>{{ $member['user']->email }}</td>
                                        <td>{{ $member['rating'] }}</td>
                                        <td class="">
                                            <div class="nav-item dropdown ms-3">
                                                <a class="nav-link dropdown-toggle text-black" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <!-- <i class="fa fa-ellipsis-v" aria-hidden="true"></i> -->
                                                </a>
                                                <ul id="action_drop" class="dropdown-menu">
                                                    @if($member['user']->id !=  auth()->user()->id)
                                                        <li>
                                                            <a class="dropdown-item text-success" href="{{ route('rating.create',$member['user']->id) }}" class="text-danger" style="text-decoration:none;">
                                                                Rate Here
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item text-success" href="{{ route('attendance.create',$member['user']->id) }}" class="text-warning" style="text-decoration:none;">
                                                            Make Attendance
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-success" href="{{ route('hr.salary.create',$member['user']->id) }}" class="text-warning" style="text-decoration:none;">
                                                            Create Salary
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>  
                                @endif
                            @endforeach
                        @endforeach

                        @foreach($data['rating'] as $member)
                            @foreach($member['user']->getRoleNames() as $role)
                                @if($role != 'manager')
                                    <tr class="text-center" style="height: 60px;">
                                        <td>
                                            @if($member['user']->img !== '' && !empty($member['user']->img))
                                            <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $member['user']->img)}}">
                                            @else
                                            no image
                                            @endif
                                        </td>
                                        <td>{{ $member['user']->name }}</td>
                                        <td>
                                            @foreach($member['user']->getRoleNames() as $role)
                                                {{ $role }}
                                                @if(!$loop->last) 
                                                ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $member['user']->created_at->format('F j, Y') }}</td>
                                        <td>{{ $member['user']->department->name }}</td>
                                        <td>{{ $member['user']->email }}</td>
                                        <td>{{ $member['rating'] }}</td>
                                        <td class="">
                                            <div class="nav-item dropdown ms-3">
                                                <a class="nav-link dropdown-toggle text-black" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <!-- <i class="fa fa-ellipsis-v" aria-hidden="true"></i> -->
                                                </a>
                                                <ul id="action_drop" class="dropdown-menu">
                                                    @if($member['user']->id !=  auth()->user()->id)
                                                        <li>
                                                            <a class="dropdown-item text-success" href="{{ route('rating.create',$member['user']->id) }}" class="text-danger" style="text-decoration:none;">
                                                                Rate Here
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item text-success" href="{{ route('attendance.create',$member['user']->id) }}" class="text-warning" style="text-decoration:none;">
                                                            Make Attendance
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-success" href="{{ route('hr.salary.create',$member['user']->id) }}" class="text-warning" style="text-decoration:none;">
                                                            Create Salary
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
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
    <!-- </div>   -->
</div>
@endsection