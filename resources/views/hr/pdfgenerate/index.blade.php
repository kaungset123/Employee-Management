@extends("layout.masters")
@section("title",$data['title'])

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.nav')
    <div class="app-main bg-white">
        @include('layout.sidebar')
        <div class="app-main__outer">
            <div class="card-body bg-white" id="all_emp_tb">
                <div class="col-md-8 offset-md-2">
                    <div id="response"></div>
                </div>
                <h4 style="font-weight: bold;" class="mb-3 text-info">{{$data['header']}}</h4>
                <form class="d-flex col-md-8 offset-md-2 mt-4" action="{{ route('pdf_generate.index') }}" method="GET">
                    @csrf
                    <a href="{{ route('pdf_generate.index', ['perPage' => $data['users']->perPage()]) }}" style="color: black;">
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
                @if(count($data['users']) > 0)
                    <table style="width: 100%;" class="table table-hover table-bordered mt-4 ">
                        <thead class="text-center">
                            <th>Image</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Start Date</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Generate PDF</th>
                        </thead>
                        <tbody>
                            @foreach($data['users'] as $member)
                                @foreach($member->getRoleNames() as $role)
                                        <tr class="text-center" style="height: 60px;">
                                            <td>
                                                @if($member->img !== '' && !empty($member->img))
                                                <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $member->img)}}">
                                                @else
                                                no image
                                                @endif
                                            </td>
                                            <td>{{ $member->name }}</td>
                                            <td>
                                                @foreach($member->getRoleNames() as $role)
                                                    {{ $role }}
                                                    @if(!$loop->last) 
                                                    ,
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $member->created_at->format('F j, Y') }}</td>
                                            <td>{{ $member->department->name }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td class="">
                                                <div class="nav-item dropdown ms-5">
                                                    <a class="nav-link dropdown-toggle text-black" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    </a>
                                                    <ul id="action_drop" class="dropdown-menu">                                              
                                                        <li>
                                                            <a href="javascript:void(0)" class="attendance-btn dropdown-item text-success" data-user-id="{{ $member->id }}" style="text-decoration:none;">
                                                                for attendance
                                                            </a>
                                                        </li>  
                                                        <li>
                                                            <a href="javascript:void(0)" class="leave-btn dropdown-item text-success " data-user-id="{{ $member->id }}" style="text-decoration:none;">
                                                                for leave
                                                            </a>
                                                        </li>                                                     
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
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
        </div>
    </div>
    @include('modal.attendance.pdf')
    @include('modal.leave.pdf')
</div>
@endsection
