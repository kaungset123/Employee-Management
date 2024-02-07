@extends("layout.master")
@section("title",@$data['title'])

@section('content')
    <div class="app-main__outer">
        @include('layout.flash_message')
            @if(count($data['projects']) > 0)
                <div class="card-header p-5">
                    <b style="font-size: 23px;" class="text-info">{{ $data['header'] }}</b>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                            <div class="app-main__inner">
                                <div class="app-inner-layout">
                                    <div class="row">
                                        @foreach($data['projects'] as $project)
                                            <div class="col-lg-6 col-xl-6 ">
                                                <div class="mb-3 card ">
                                                    <div class="card-header-tab card-header">
                                                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                            <!-- <i class="header-icon lnr-shirt mr-3 text-muted opacity-6"> </i> -->
                                                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                            {{$project->name}}
                                                        </div>
                                                        <div class="btn-actions-pane-right actions-icon-btn d-flex">
                                                            <a href="{{route('project.restore',$project->id)}}" style="text-decoration: none;" >Restore</a>
                                                            <!-- <a href="{{route('project.force_delete',$project->id)}}" style="text-decoration: none;color:red;" class="col-md-2">Delete</a> -->
                                                            <form method="post" action="{{ route('project.force_delete',$project->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" style="border:none;cursor:pointer;background:none;" class="text-danger" onclick="return confirm('Are you sure you want to permanently delete this item?')">
                                                                    <!-- <i class="fa-solid fa-trash text-danger"></i> -->
                                                                    <b>ForceDelete</b>
                                                                </button>
                                                            </form>                                                           
                                                        </div>
                                                    </div>
                                                    <div class="widget-chart widget-chart2 text-left p-0">
                                                        <div class="widget-chat-wrapper-outer">
                                                            <div class="widget-chart-content widget-chart-content-lg">
                                                                <b>Start Date :  <i style="color:blue;">{{ $project->start_date }}</i></b>
                                                                <b>End Date : <i style="color:red;"> {{ $project->end_date }} </i> </b>
                                                                <b>Period : <i style="color:red;"> {{ $project->projectPeriod}} </i> </b>                                                               
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
                                                                                    <img src="{{ asset( '/storage/uploads/' . $project->projectManager->img) }}" style="width:50px; height:50px;border-radius:25px;">
                                                                                </div>
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading">{{ $project->projectManager->name }}</div>
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
                                                                @foreach($project->membersExceptManager as $member) 
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
                        <div class="tab-pane" id="tab-eg2-1" role="tabpanel">
                        </div>
                    </div> 
                </div>
            @else
                <div class="card-header">
                    <b style="font-size: 23px;" class="text-info">{{ $data['header'] }}</b>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                            <div class="app-main__inner">
                                <div class="app-inner-layout">
                                        <h4 style="text-align: center;color:red;" class="mt-5">There is no deleted item!</h4>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-eg2-1" role="tabpanel">
                        </div>
                    </div> 
                </div>
            @endif         
    </div>
@endsection