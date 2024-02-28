@extends("layout.master")
@section("title",@$data['title'])

@section('content')
<div class="app-main__outer">
    <div>
       @include('layout.flash_message')
    </div>
    <div class="card-header p-5"><b style="font-size: 23px;" class="text-info">Completed Projects</b>
        <div class="btn-actions-pane-right">
            <div class="nav">
                <a href="{{ route('project.index') }}" class="btn-pill btn-wide  btn btn-outline-info btn-sm">
                    Projects
                </a>
                <a  href="{{ route('project.progress') }}" class="btn-pill btn-wide  mr-1 ml-1  btn btn-outline-info btn-sm">
                    Running
                </a>
                <a data-toggle="tab" href="#tab-eg2-2" class="btn-pill btn-wide active mr-1 ml-1  btn btn-outline-info btn-sm">Completed</a>
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
                                                {{$complete['project']->name}}
                                            </div>
                                            <div class="btn-actions-pane-right actions-icon-btn">
                                                <a href="{{route('project.detail',$complete['project']->id)}}" style="text-decoration: none;">View</a>
                                            </div>
                                        </div>
                                        <div class="widget-chart widget-chart2 text-left p-0">
                                            <div class="widget-chat-wrapper-outer">
                                                <div class="widget-chart-content widget-chart-content-lg">
                                                    <b>Start Date : <i style="color:blue;">{{ $complete['project']->start_date }}</i></b>
                                                    <b>End Date : <i style="color:red;"> {{ $complete['project']->end_date }} </i> </b>
                                                    <b>Period : <i style="color:red;"> {{ $complete['project']->projectPeriod}} </i> </b>
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
                                                                        @if(!empty($complete['project']->projectManager->img))
                                                                            <img src="{{ asset( '/storage/uploads/' . $complete['project']->projectManager->img) }}" style="width:50px; height:50px;border-radius:25px;">
                                                                        @else
                                                                            <img class="manager_img" src="{{ asset('/images/user.jpg') }}" style="width:50px; height:50px;border-radius:25px;">
                                                                        @endif
                                                                    </div>
                                                                    <div class="widget-content-left">
                                                                        <div class="widget-heading">{{$complete['project']->projectManager->name }}</div>
                                                                    </div>
                                                                    <div class="widget-content-right">
                                                                        <div class="fsize-1 text-focus">
                                                                            <div class="btn-actions-pane-right actions-icon-btn">
                                                                                <div class="btn-group dropdown">
                                                                                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                                                                        Project Leader
                                                                                    </button>                                                                                     
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
                                                        @foreach($complete['project']->membersExceptManager as $member)
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
        @else
            <h4 class="text-danger text-center mt-5">no completed project</h4>
        @endif
        <div class="pagination">
            {{ $data['projects']->links() }}
        </div> 
    </div>
</div>
@endsection