@extends("layout.master")
@section("title",@$data['title'])

@section('content')
        <div class="app-main__outer">
            <div class="card-header p-5 text-info"><b style="font-size: 23px;">{{ $data['header'] }}</b>
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a data-toggle="tab" href="#tab-eg2-0" class="btn-pill btn-wide bg-info active btn btn-outline-info btn-sm">Running</a>
                        <a  href="{{ route('project.completed') }}" class="btn-pill btn-wide  mr-1 ml-1  btn btn-outline-info btn-sm">Completed</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="d-flex col-md-8 offset-md-2"  action="{{ route('project.myProject') }}" method="GET" >
                    @csrf
                    <a href="{{ route('project.myProject', ['perPage' => $data['projects']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['projects']->perPage() }}">
                    <input class="form-control border-info" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
                    <input class="form-control border-info" type="text" name="member_name" value="{{ $data['memberName'] }}" placeholder="member name" aria-label="Search">
                    <input type="date" class="form-control border-info" name="created_at" value="{{ $data['created'] }}" >
                    <button class="btn btn-outline-info " type="submit">Search</button>
                </form>
                <div class="">
                    @include('layout.projectPageLimit')
                </div>
                @include('layout.flash_message')
                <div class="tab-content">
                    @if(count($data['projectProgress']) > 0)
                        <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                            <div class="app-main__inner">
                                <div class="app-inner-layout">
                                    <div class="">
                                        @foreach($data['projectProgress'] as $project_id => $progress)
                                            <div class="col-md-12">
                                                <div class="mb-3 card p-3">
                                                    <div class="card-header-tab card-header">
                                                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                            {{$progress['project']->name}} 
                                                        </div>
                                                        <div class="btn-actions-pane-right actions-icon-btn">
                                                                <a href="{{route('project.detail',$progress['project']->id)}}" style="text-decoration: none;">View</a>
                                                            <a href="{{ route('project.myTask',$progress['project']->id) }}" class="bg-info" id="my_task" >
                                                                My Tasks
                                                            </a>
                                                            @if(auth()->user()->id == $progress['project']->project_manager_id )
                                                                <a href="{{ route('task.create',$progress['project']->id ) }}" class="bg-info" id="assign_task" >
                                                                    Assign Tasks
                                                                </a>  
                                                                <a href="{{ route('task.index',$progress['project']->id) }}" class="bg-info" id="all_task" >
                                                                    All Tasks
                                                                </a>
                                                                @if($progress['project']->status == 0)
                                                                    <a href="{{ route('project.start',$progress['project']->id) }}" id="project_start" class="bg-success">
                                                                        Start
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="widget-chart widget-chart2 text-left p-0">
                                                        <div class="widget-chat-wrapper-outer">
                                                            <div class="widget-chart-content widget-chart-content-lg">
                                                                <b style="margin-bottom: 8px;">Start Date :  <i>{{ $progress['project']->start_date }}</i></b>
                                                                <b style="margin-bottom: 8px;">End Date : <i> {{ $progress['project']->end_date }} </i> </b>
                                                                <b>Period : <i> {{ $progress['project']->projectPeriod}} </i> </b>                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pt-2 pb-0 card-body">
                                                        <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 font-weight-normal ">Team Members</h6>
                                                        <div class="scroll-area-md shadow-overflow">
                                                            <div class="scrollbar-container">
                                                                <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                                                    <!-- project Manager only -->
                                                                    <li class="list-group-item">
                                                                        <div class="widget-content p-2">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left mr-3 " id="all_pj ">
                                                                                    @if(!empty($progress['project']->projectManager->img))
                                                                                        <img src="{{ asset( '/storage/uploads/' . $progress['project']->projectManager->img) }}" style="width:50px; height:50px;border-radius:25px;">
                                                                                    @else
                                                                                        <img class="manager_img" src="{{ asset('/images/user.jpg') }}" style="width:50px; height:50px;border-radius:25px;">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading">{{ $progress['project']->projectManager->name }}</div>
                                                                                </div>
                                                                                <div class="widget-content-right">
                                                                                    <div class="fsize-1 text-focus">
                                                                                        <div class="btn-actions-pane-right actions-icon-btn">
                                                                                            <div class="btn-group dropdown">
                                                                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                                                                                        Project Leader
                                                                                                </button>
                                                                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                                                                                    <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                                                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-inbox"> </i><span>Menus</span></button>
                                                                                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-file-empty"> </i><span>Settings</span></button>
                                                                                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-book"> </i><span>Actions</span></button>
                                                                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                                                                    <div class="p-1 text-right">
                                                                                                        <button class="mr-2 btn-shadow btn-sm btn btn-link">View Details</button>
                                                                                                        <button class="mr-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="main-card mb-3 card">

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <!-- project Manager only -->
                                                                @foreach($progress['project']->membersExceptManager as $member) 
                                                                    <li class="list-group-item">
                                                                        <div class="widget-content p-2">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left mr-3 " id="all_pj ">
                                                                                    @if(!empty($member->img))
                                                                                        <img src="{{ asset( '/storage/uploads/' . $member->img ) }}" style="width:50px; height:50px;border-radius:25px;">
                                                                                    @else
                                                                                        <img class="manager_img" src="{{ asset('/images/user.jpg') }}" style="width:50px; height:50px;border-radius:25px;">
                                                                                   @endif
                                                                                </div>
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading">{{ $member->name }}</div>
                                                                                </div>
                                                                                <div class="widget-content-right">
                                                                                    <div class="fsize-1 text-focus">
                                                                                        <div class="btn-actions-pane-right actions-icon-btn">
                                                                                            <div class="btn-group dropdown">
                                                                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                                                                                        Team Member
                                                                                                </button>
                                                                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                                                                                    <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                                                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-inbox"> </i><span>Menus</span></button>
                                                                                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-file-empty"> </i><span>Settings</span></button>
                                                                                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-book"> </i><span>Actions</span></button>
                                                                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                                                                    <div class="p-1 text-right">
                                                                                                        <button class="mr-2 btn-shadow btn-sm btn btn-link">View Details</button>
                                                                                                        <button class="mr-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="main-card mb-3 card">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{$progress['progress']}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$progress['progress']}}%;">
                                                            {{number_format($progress['progress'],1)}}%
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <h4 class="text-danger text-center mt-5">no project!</h4>
                    @endif
                    <div id="pagination">
                        {{ $data['projects']->links() }}
                    </div>
                </div> 
            </div>           
        </div>
@endsection