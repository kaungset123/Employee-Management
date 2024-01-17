@extends("layout.master")
@section("title",@$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card-header p-5">
        <b style="font-size: 23px;">All Projects</b>
        <div class="btn-actions-pane-right">
            <div class="nav">
                <a data-toggle="tab" href="#tab-eg2-0" class="btn-pill btn-wide active btn btn-outline-alternate btn-sm">Projects</a>
                <a href="{{ route('project.progress') }}" class="btn-pill btn-wide mr-1 ml-1  btn btn-outline-alternate btn-sm">
                    Running
                </a>
                <a href="{{ route('project.complete') }}" class="btn-pill btn-wide mr-1 ml-1  btn btn-outline-alternate btn-sm">Completed</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                @include('layout.flashmessage')
                <form class="d-flex col-md-8 offset-md-2" action="{{ route('project.index') }}" method="GET">
                    <a href="{{ route('project.index',['perPage' => $data['projects']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['projects']->perPage() }}">
                    @include('layout.projectSearch')
                </form>
                <div class="d-flex" style="position: relative;">
                    <div class="mt-3" >
                        @include('layout.projectPageLimit')
                    </div>
                    <div class="" style="position: absolute;right:1rem;">
                        <a href="{{ route('project.create') }}">
                            <i class="fa-solid fa-circle-plus mt-3" style="font-size: 30px;color:blueviolet;"></i>
                        </a>
                        <a href="{{ route('project.deletelist') }}" id="project_delete_list">
                            Deleted List
                        </a>
                    </div>
                </div>
                @if(count($data['projectProgress']) > 0)
                <div class="app-main__inner p-0 mt-3">
                    <div class="app-inner-layout">
                        <div class="row">
                            @foreach($data['projectProgress'] as $progress)
                            <div class="col-lg-6 col-xl-6 p-3">
                                <div class="mb-3 card p-3">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                            {{$progress['project']->name}}
                                        </div>
                                        <div class="btn-actions-pane-right actions-icon-btn d-flex justify-content-end">
                                            @if($progress['project']->status != 0)
                                                <a href="{{route('project.detail',$progress['project']->id)}}" style="text-decoration: none;">View</a>
                                            @else
                                                <b> not started!</b>
                                            @endif
                                            <a href="{{route('project.edit',$progress['project']->id)}}" style="text-decoration: none;" class="col-md-2">Edit</a>
                                            <form action="{{ route('project.destroy',$progress['project']->id) }}" method="post" class="col-md-3">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border: none;cursor:pointer;background:#fff;">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="widget-chart widget-chart2 text-left p-0">
                                        <div class="widget-chat-wrapper-outer">
                                            <div class="widget-chart-content widget-chart-content-lg">
                                                <b>Start Date : <i style="color:blue;">{{ $progress['project']->start_date }}</i></b>
                                                <b>End Date : <i style="color:red;"> {{ $progress['project']->end_date }} </i> </b>
                                                <b>Period : <i style="color:red;"> {{ $progress['project']->projectPeriod}} </i> </b>
                                                <b>Deadline : {{ $progress['deadlineWarning']['difference_in_days'] }} days left</b>
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
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $progress['progress'] }}%;" aria-valuenow="{{ $progress['progress'] }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ $progress['progress'] }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <h4 class="text-danger text-center">no match result!</h4>
                @endif
            </div>
        </div>
        <div id="pagination">
            {{ $data['projects']->links() }}
        </div>
    </div>
</div>
@endsection