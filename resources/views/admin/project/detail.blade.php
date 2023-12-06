@extends("layout.master")
@section("title","Admin Home")

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.necess')
    <div class="app-main p-0">
        @include('layout.sidebar')
        <div class="app-main__outer mt-4">
            <div class="col-lg-6 col-xl-11">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>Project Detail</div>
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <div class="btn-group dropdown">
                                    <a href="/admin/project/edit">
                                         Edit
                                    </a>
                                <!-- <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                    <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-inbox"> </i><span>Menus</span></button>
                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-file-empty"> </i><span>Settings</span></button>
                                    <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-book"> </i><span>Actions</span></button>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <div class="p-1 text-right">
                                        <button class="mr-2 btn-shadow btn-sm btn btn-link">View Details</button>
                                        <button class="mr-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="widget-chart widget-chart2 text-left p-0">
                        <div class="widget-chat-wrapper-outer">
                            <div class="widget-chart-content widget-chart-content-lg">
                                <p><b>project name:</b></p>
                                <p><b>start date:</b></p>
                                <p><b>end date:</b></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">25%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-2 pb-0 card-body">
                    <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 font-weight-normal">Top Performing</h6>
                    <div class="scroll-area-md shadow-overflow">
                        <div class="scrollbar-container">
                            <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3 ms-3">
                                                <div class="icon-wrapper m-0">
                                                    <div class="progress-circle-wrapper">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress circle-progress-gradient">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">User Name</div>
                                                <div class="widget-subheading mt-1 opacity-10">
                                                    <!-- <div class="badge badge-pill badge-dark">$152</div> -->
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                            
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3 ms-3">
                                                <div class="icon-wrapper m-0">
                                                    <div class="progress-circle-wrapper">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress circle-progress-gradient">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">User Name</div>
                                                <div class="widget-subheading mt-1 opacity-10">
                                                    <!-- <div class="badge badge-pill badge-dark">$152</div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3 ms-3">
                                                <div class="icon-wrapper m-0">
                                                    <div class="progress-circle-wrapper">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress circle-progress-gradient">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">User Name</div>
                                                <div class="widget-subheading mt-1 opacity-10">
                                                    <!-- <div class="badge badge-pill badge-dark">$152</div> -->
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                            
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>
@include('layout.app_drawer_wrapper')

@endsection