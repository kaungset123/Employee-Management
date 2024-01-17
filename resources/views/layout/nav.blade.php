<div class="app-header header-shadow" >
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    
            <div class="app-header__content">
                <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>       
                </div>
                <div class="app-header-right">                   
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <!-- <img width="42" class="rounded-circle" src="" alt=""> -->
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-3" role="menu" aria-hidden="true" class="p-0 rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-info p-3" >
                                                    <div class="menu-header-content text-left">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-3">
                                                                    <a href="{{ route('user.profile',auth()->user()->id) }}">
                                                                        <img style="width:56px; height:56px;border-radius:28px;"
                                                                            src="{{ asset('storage/uploads/' . auth()->user()->img) }}"
                                                                            alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">{{auth()->user()->name}}
                                                                    </div>
                                                                    <div class="widget-subheading opacity-8">Role : {{ auth()->user()->getRoleNames()->first() }}
                                                                    </div>
                                                                    <div class="widget-subheading opacity-8">
                                                                        @if(auth()->user()->department != null)
                                                                            Department : {{ auth()->user()->department->name }}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right mr-2">                                                                    
                                                                    <form class="inline" method="POST" action="{{ route('logout') }}">
                                                                        @csrf
                                                                        <button type="submit" class="btn-pill btn-shadow btn-shine btn btn-focus">
                                                                            <i class=""></i> Logout
                                                                        </button>
                                                                    </form>                                                                                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <li class="mt-3 p2 ml-auto">
                                                                <a class="mt-3" href="{{ route('profile.edit',auth()->user()->id) }}">
                                                                    <button class="btn btn-sm bg-primary text-white">change profile</button>
                                                                </a>
                                                            </li>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="scroll-area-xs" style="height: 40px;">
                                                <div class="scrollbar-container ps">
                                                    
                                                </div>
                                            </div>                                           -->
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        {{auth()->user()->name}}
                                    </div>
                                    <div class="widget-subheading">
                                        
                                    </div>
                                </div>
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-btn-lg">
                        <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>        
            </div>
        </div>
 </div>