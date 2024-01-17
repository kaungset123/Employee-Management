@extends("layout.master")
@section("title",@$data['title'])

@section('content')
        <div class="app-main__outer">
            <div class="card-header p-5"><b style="font-size: 23px;">{{ $data['header'] }}</b>
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a data-toggle="tab" href="#tab-eg2-0" class="btn-pill btn-wide active btn btn-outline-alternate btn-sm">Running</a>
                        <a  href="{{ route('project.completed') }}" class="btn-pill btn-wide mr-1 ml-1  btn btn-outline-alternate btn-sm">Completed</a>
                        <!-- <a data-toggle="tab" href="#tab-eg2-2" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm"></a>     -->
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="d-flex col-md-8 offset-md-2"  action="{{ route('project.myproject') }}" method="GET" >
                    @csrf
                    <a href="{{ route('project.myproject', ['perPage' => $data['projects']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['projects']->perPage() }}">
                    <input class="form-control me-2" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
                    <input class="form-control me-2" type="text" name="member_name" value="{{ $data['memberName'] }}" placeholder="member name" aria-label="Search">
                    <input type="date" class="form-control" name="created_at" value="{{ $data['created'] }}" >
                    <button class="btn btn-outline-success " type="submit">Search</button>
                </form>
                <div class="">
                    @include('layout.projectPageLimit')
                </div>
                @include('layout.flashmessage')
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
                                                            <!-- <i class="header-icon lnr-shirt mr-3 text-muted opacity-6"> </i> -->
                                                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                            {{$progress['project']->name}} 
                                                        </div>
                                                        <div class="btn-actions-pane-right actions-icon-btn">
                                                            @if($progress['project']->status != 0)
                                                                <a href="{{route('project.detail',$progress['project']->id)}}" style="text-decoration: none;">View</a>
                                                            @else
                                                                not started
                                                            @endif
                                                            <a href="{{ route('project.mytask',$progress['project']->id) }}" id="my_task" >
                                                                My Tasks
                                                            </a>
                                                            @if(auth()->user()->id == $progress['project']->project_manager_id )
                                                                <a href="{{ route('task.create',$progress['project']->id ) }}"  id="assign_task" >
                                                                    Assign Tasks
                                                                </a>  
                                                                <a href="{{ route('task.index',$progress['project']->id) }}" id="all_task" >
                                                                    All Tasks
                                                                </a>
                                                                @if($progress['project']->status == 0)
                                                                    <a href="{{ route('project.start',$progress['project']->id) }}" id="project_start">
                                                                        Let Start!
                                                                    </a>
                                                                @endif

                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="widget-chart widget-chart2 text-left p-0">
                                                        <div class="widget-chat-wrapper-outer">
                                                            <div class="widget-chart-content widget-chart-content-lg">
                                                                <b>Start Date :  <i style="color:blue;">{{ $progress['project']->start_date }}</i></b>
                                                                <b>End Date : <i style="color:red;"> {{ $progress['project']->end_date }} </i> </b>
                                                                <b>Period : <i style="color:red;"> {{ $progress['project']->projectPeriod}} </i> </b>                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pt-2 pb-0 card-body">
                                                        <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 font-weight-normal">Developers</h6>
                                                        <div class="scroll-area-md shadow-overflow">
                                                            <div class="scrollbar-container">
                                                                <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                                                    <!-- project Manager only -->
                                                                    <li class="list-group-item">
                                                                        <div class="widget-content p-2">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left mr-3 " id="all_pj ">
                                                                                    <img src="{{ asset( '/storage/uploads/' . $progress['project']->projectManager->img) }}" style="width:50px; height:50px;border-radius:25px;">
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
                                                                                    <img src="{{ asset( '/storage/uploads/' . $member->img ) }}" style="width:50px; height:50px;border-radius:25px;">
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
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{$progress['progress']}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$progress['progress']}}%;">
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
                        <h3 class="text-danger text-center mt-5">no project!</h3>
                    @endif
                    <div id="pagination">
                        {{ $data['projects']->links() }}
                    </div>
                </div> 
            </div>           
        </div>
@endsection