@extends("layout.master")
@section("title",@$data['title'])

@section('content')
<div class="app-main__outer">
    <div>
       @include('layout.flashmessage')
    </div>
    <div class="card-header p-5"><b style="font-size: 23px;">Completed Projects</b>
        <div class="btn-actions-pane-right">
            <div class="nav">
                <a href="{{ route('project.index') }}" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm">
                    Projects
                </a>
                <a  href="{{ route('project.progress') }}" class="btn-pill btn-wide  mr-1 ml-1  btn btn-outline-alternate btn-sm">
                    Running
                </a>
                <a data-toggle="tab" href="#tab-eg2-2" class="btn-pill btn-wide active mr-1 ml-1  btn btn-outline-alternate btn-sm">Completed</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form class="d-flex col-md-8 offset-md-2"  action="{{ route('project.complete') }}" method="GET" >
            <a href="{{ route('project.complete',['perPage' => $data['projects']->perPage()]) }}" style="color: black;">
                <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
            </a>
            <input type="hidden" name="perPage" value="{{ $data['projects']->perPage() }}">
            @include('layout.projectSearch')
        </form>
        <div class="mt-2">
            @include('layout.projectPageLimit')
        </div>
        @if(count($data['projectProgress']) > 0 )  
            <div class="tab-content">                    
                <div class="tab-pane" id="tab-eg2-2" role="tabpanel">               
                    <div class="app-main__inner">
                        <div class="app-inner-layout">
                            <div class="row">
                                @foreach($data['projectProgress'] as $complete)                                      
                                    <div class="col-lg-6 col-xl-6 ">
                                        <div class="mb-3 card p-3">
                                            <div class="card-header-tab card-header">
                                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                    <!-- <i class="header-icon lnr-shirt mr-3 text-muted opacity-6"> </i> -->
                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                    {{$complete->name}}
                                                </div>
                                                <div class="btn-actions-pane-right actions-icon-btn">
                                                    <a href="{{route('project.detail',$complete->id)}}" style="text-decoration: none;">View</a>
                                                    <a href="{{route('project.edit',$complete->id)}}" style="text-decoration: none;" class="col-md-2">Edit</a>
                                                </div>
                                            </div>
                                            <div class="widget-chart widget-chart2 text-left p-0">
                                                <div class="widget-chat-wrapper-outer">
                                                    <div class="widget-chart-content widget-chart-content-lg">
                                                        <b>Start Date : <i style="color:blue;">{{ $complete->start_date }}</i></b>
                                                        <b>End Date : <i style="color:red;"> {{ $complete->end_date }} </i> </b>
                                                        <b>Period : <i style="color:red;"> {{ $complete->projectPeriod}} </i> </b>
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
                                                                            <img src="{{ asset( '/storage/uploads/' . $complete->projectManager->img) }}" style="width:50px; height:50px;border-radius:25px;">
                                                                        </div>
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading">{{$complete->projectManager->name }}</div>
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
                                                            @foreach($complete->membersExceptManager as $member)
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
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>                      
                    </div>
                </div>              
            </div>
        @else
            <h4 class="text-danger text-center mt-5">no completed project</h4>
        @endif
        <div class="pagination">
            {{ $data['projects']->links() }}
        </div> 
    </div>
</div>
@endsection