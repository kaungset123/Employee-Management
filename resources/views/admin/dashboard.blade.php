@extends("layout.master")
@section("title","Admin Home")

@section('content')
<div class="app-main__outer mt-5 col-md-10 offset-md-1">
    <div class="mb-3 card">
        @include('layout.flash_message')
        <div class="card-header-tab card-header">
            <div class="text-info card-header-title font-size-lg text-capitalize font-weight-bold">
                Projects
            </div>
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
                            <div class="widget-numbers">{{ $data['status']['all_count'] }}</div>
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
                            <div class="widget-numbers"><span>{{ $data['status']['run_count'] }}</span></div>
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
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <div class="text-info card-header-title font-size-lg text-capitalize font-weight-bold">
                <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                Departments
            </div>
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