@extends("layout.master")
@section("title",'SuperAdmin Home')

@section('content')
<div class="app-main__outer mt-5 col-md-10 offset-md-1">
    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <div class="card-header-title font-size-lg text-capitalize font-weight-bold">
                Projects
            </div>
            <!-- <div class="btn-actions-pane-right text-capitalize">
                    <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">View
                        All</button>
                </div> -->
        </div>
        <div class="no-gutters d-flex">
            <a href="{{ route('project.index') }}" style="color:#000;text-decoration:none;">
                <div class="col-sm-6 col-md-4 col-xl-4">
                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                        <div class="icon-wrapper rounded-circle">
                            <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="widget-chart-content">
                            <div class="widget-subheading">
                                <a href="{{ route('project.index') }}" style="text-decoration:none;color:#000;">All Projects</a>
                            </div>
                            <div class="widget-numbers text-warning">{{ $data['status']['all_count'] }}</div>
                            <!-- <div class="widget-description opacity-8 text-focus">
                                    <div class="d-inline text-danger pr-1">
                                        <i class="fa fa-angle-down"></i>
                                        <span class="pl-1">54.1%</span>
                                    </div>
                                    less earnings
                                </div> -->
                        </div>
                    </div>
                    <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
            </a>
            <a href="{{ route('project.progress') }}" style="color:#000;text-decoration:none;">
                <div class="col-sm-6 col-md-4 col-xl-4">
                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                        <div class="icon-wrapper rounded-circle">
                            <div class="icon-wrapper-bg opacity-9 bg-danger"></div>
                            <i class="fas fa-sort-amount-up"></i>
                        </div>
                        <div class="widget-chart-content">
                            <div class="widget-subheading">
                                <a href="{{ route('project.index') }}" style="text-decoration: none;color:#000;">
                                    Running Projects
                                </a>
                            </div>
                            <div class="widget-numbers text-danger"><span>{{ $data['status']['run_count'] }}</span></div>
                            <!-- <div class="widget-description opacity-8 text-focus">
                                    Grow Rate:
                                    <span class="text-info pl-1">
                                        <i class="fa fa-angle-down"></i>
                                        <span class="pl-1">14.1%</span>
                                    </span>
                                </div> -->
                        </div>
                    </div>
                    <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
            </a>
            <a href="{{ route('project.complete') }}" style="color:#000;text-decoration:none;">
                <div class="col-sm-12 col-md-4 col-xl-4">
                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                        <div class="icon-wrapper rounded-circle">
                            <div class="icon-wrapper-bg opacity-9 bg-success"></div>
                            <i class="fas fa-marker"></i>
                        </div>
                        <div class="widget-chart-content">
                            <div class="widget-subheading">
                                <a href="{{ route('project.index') }}" style="text-decoration:none;color:#000;">
                                    Completed Projected
                                </a>
                            </div>
                            <div class="widget-numbers text-success"><span>{{ $data['status']['complete_count'] }}</span></div>
                            <!-- <div class="widget-description text-focus">
                                    Increased by
                                    <span class="text-warning pl-1">
                                        <i class="fa fa-angle-up"></i>
                                        <span class="pl-1">7.35%</span>
                                    </span>
                                </div> -->
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <div class="card-header-title font-size-lg text-capitalize font-weight-bold">
                <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                Departments
            </div>
            <!-- <div class="btn-actions-pane-right text-capitalize">
                    <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">View
                        All</button>
                </div> -->
        </div>
        <div class="no-gutters row">
            @foreach($data['status']['departments'] as $dept)
            <div class="col-sm-6 col-md-4 col-xl-4">
                <a href="{{ route('department.show',$dept['department_id']) }}" style="color:#000;text-decoration:none;">
                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                        <div class="icon-wrapper rounded-circle">
                            <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="widget-chart-content">
                            <div class="widget-subheading">{{ $dept['department_name'] }} department</div>
                            <div class="widget-numbers">{{ $dept['memberCount'] }} </div>
                            <div class="widget-description opacity-8 text-focus">                              
                                @foreach($dept['users'] as $user)
                                    @if($user->hasRole('manager'))
                                        Manager: {{ $user->name }}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </a>
                <div class="divider m-0 d-md-none d-sm-block"></div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection