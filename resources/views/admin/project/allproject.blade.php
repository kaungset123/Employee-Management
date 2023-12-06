@extends("layout.master")
@section("title","Admin Home")

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.necess')
    <div class="app-main p-0">
        @include('layout.sidebar')
        <div class="app-main__outer">
        <div class="main-card mb-3 mt-3 card col-sm-1 col-lg-10 col-xl-11 ">
                                        <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>All Projects
                                            <div class="btn-actions-pane-right">
                                                <div class="nav">
                                                    <a data-toggle="tab" href="#tab-eg2-0" class="btn-pill btn-wide active btn btn-outline-alternate btn-sm">completed</a>
                                                    <a data-toggle="tab" href="#tab-eg2-1" class="btn-pill btn-wide mr-1 ml-1  btn btn-outline-alternate btn-sm">running</a>
                                                    <!-- <a data-toggle="tab" href="#tab-eg2-2" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm"></a>     -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                                                    <div class="app-main__inner">
                                                        <div class="app-inner-layout">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <div class="mb-3 card">
                                                                            <div class="card-header-tab card-header">
                                                                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                                                    <!-- <i class="header-icon lnr-shirt mr-3 text-muted opacity-6"> </i> -->
                                                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                                                    ERP System
                                                                                </div>
                                                                                <div class="btn-actions-pane-right actions-icon-btn">
                                                                                    <a href="/admin/project/detail">Detail</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="widget-chart widget-chart2 text-left p-0">
                                                                                    <div class="widget-chat-wrapper-outer">
                                                                                        <div class="widget-chart-content widget-chart-content-lg">
                                                                                        <p>Start Date :</p>
                                                                                        <p>End Date :</p>
                                                                                     
                                                                                    </div>
                                                                                        <!-- <div class="widget-chart-wrapper widget-chart-wrapper-xlg opacity-10 m-0">
                                                                                            <div id="dashboard-sparkline-3"></div>
                                                                                        </div> -->
                                                                                       
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                            <div class="pt-2 pb-0 card-body">
                                                                                <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 font-weight-normal">Authors</h6>
                                                                                <div class="scroll-area-md shadow-overflow">
                                                                                    <div class="scrollbar-container">
                                                                                        <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                                                                            <li class="list-group-item">
                                                                                                <div class="widget-content p-2">
                                                                                                    <div class="widget-content-wrapper">
                                                                                                       
                                                                                                        <div class="widget-content-left">
                                                                                                            <div class="widget-heading"></div>
                                                                                                         
                                                                                                        </div>
                                                                                                        <div class="widget-content-right">
                                                                                                            <div class="fsize-1 text-focus">
                                                                                                              
                                                                                                                <div>05/06/2023</div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <div class="widget-content p-2">
                                                                                                    <div class="widget-content-wrapper">
                                                                                                      
                                                                                                        <div class="widget-content-left">
                                                                                                            <div class="widget-heading">Created at</div>
                                                                                                      
                                                                                                        </div>
                                                                                                        <div class="widget-content-right">
                                                                                                            <div class="fsize-1 text-focus">
                                                                                                               
                                                                                                                <div>05/06/2023</div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <div class="widget-content p-2">
                                                                                                    <div class="widget-content-wrapper">
                                                                                                        
                                                                                                        <div class="widget-content-left">
                                                                                                            <div class="widget-heading">Created at</div>
                                                                                                           
                                                                                                        </div>
                                                                                                        <div class="widget-content-right">
                                                                                                            <div class="fsize-1 text-focus">
                                                                                                             
                                                                                                                <div>05/06/2023</div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <div class="widget-content p-2">
                                                                                                    <div class="widget-content-wrapper">
                                                                                                       
                                                                                                        <div class="widget-content-left">
                                                                                                            <div class="widget-heading">Created at</div>
                                                                                                            
                                                                                                        </div>
                                                                                                        <div class="widget-content-right">
                                                                                                            <div class="fsize-1 text-focus">
                                                                                                            
                                                                                                                <div>05/06/2023</div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <div class="widget-content p-2">
                                                                                                    <div class="widget-content-wrapper">
                                                                                                        <div class="widget-content-left mr-3">
                                                                                                                <img width="38" class="rounded-circle" src="assets/images/avatars/2.jpg" alt="">
                                                                                                            </div>
                                                                                                        <div class="widget-content-left">
                                                                                                            <div class="widget-heading">Created at</div>
                                                                                                          
                                                                                                        </div>
                                                                                                        <div class="widget-content-right">
                                                                                                            <div class="fsize-1 text-focus">
                                                                                                                <div>05/06/2023</div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <div class="widget-content p-2">
                                                                                                    <div class="widget-content-wrapper">
                                                                                                        <div class="widget-content-left mr-3 " id="all_pj">
                                                                                                            <img src="">
                                                                                                        </div>
                                                                                                        <div class="widget-content-left">
                                                                                                            <div class="widget-heading">Created at</div>
                                                                                                            <!-- <div class="widget-subheading mt-1 opacity-10">
                                                                                                                    <div class="badge badge-pill badge-dark">$53</div>
                                                                                                                </div> -->

                                                                                                        </div>
                                                                                                        <div class="widget-content-right">
                                                                                                            <div class="fsize-1 text-focus">
                                                                                                              
                                                                                                                <div class="btn-actions-pane-right actions-icon-btn">
                                                                                                                    <div class="btn-group dropdown">
                                                                                                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                                                                                                            <!-- <i class="pe-7s-menu btn-icon-wrapper"></i> -->
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
                                                                                        </ul>
                                                                              
                                                                                    </div>
                                                                               
                                                                                </div>
                                                                                   <div class="progress">
                                                                                <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">25%</div>
                                                                            </div>
                                                                            </div>
                                                                   
                                                                        </div>

                                                                    </div>
                                                                    </div>
                                                                   
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab-eg2-1" role="tabpanel">
                                                   
                                                </div>
                                            </div>
                                        </div>
                    </div>    
    </div>
</div>
@include('layout.app_drawer_wrapper')

@endsection