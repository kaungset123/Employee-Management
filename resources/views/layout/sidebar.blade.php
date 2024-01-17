<div class="app-sidebar sidebar-shadow ">
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
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">
                                @role('admin')
                                    <a href="{{ route('admin.dashboard') }}">
                                         ADMIN DASHBOARD 
                                    </a>
                                @endrole  
                                @role('employee') 
                                    <a href="{{ route('employee.dashboard') }}">
                                    EMPLOYEE DASHBOARD
                                    </a>
                                @endrole
                                @role('HR') 
                                    <a href="{{ route('hr.dashboard') }}">
                                        HR DASHBOARD
                                    </a>
                                @endrole
                                @role('manager') 
                                    <a href="{{ route('manager.dashboard') }}">
                                        MANAGER DASHBOARD
                                    </a>
                                @endrole
                            </li>
                            @role('admin')
                                <li>
                                    <a href="#">
                                        <i class="fas fa-building"></i>
                                            Department                                  
                                    </a>
                                    <ul>
                                        <li class="{{ request()->routeIs('department.index')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('department.index')}}">
                                                <i class="metismenu-icon"></i>
                                                All Department
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole
                            <li>
                                <a href="#">
                                    <i class="fa fa-address-book" aria-hidden="true"></i>
                                        Projects                                  
                                </a>
                                <ul>
                                    @role('admin')
                                        <li class="{{ request()->routeIs('project.index')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('project.index')}}">
                                                <i class="metismenu-icon"></i>
                                                All Project
                                            </a>
                                        </li>
                                        <li class="{{ request()->routeIs('project.create')  ? 'mm-active'  : '' }}">
                                            <a  href="{{route('project.create')}}">
                                                <i class="metismenu-icon">
                                                </i>Add Project
                                            </a>
                                        </li>
                                    @endrole  
                                    @hasanyrole('manager|employee')                                     
                                        <li class="{{ request()->routeIs('project.myproject')  ? 'mm-active'  : '' }}">
                                            <a  href="{{route('project.myproject')}}">
                                                <i class="metismenu-icon">
                                                </i>My Project
                                            </a>
                                        </li>
                                    @endhasanyrole
                                </ul>
                            </li>
                            @role('admin')
                                <li>
                                    <a href="#">
                                        <i class="fa-solid fa-users"></i>
                                            Employee
                                    </a>
                                    <ul>
                                        <li class="{{ request()->routeIs('user.index')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('user.index')}}">
                                                <i class="metismenu-icon">
                                                </i>All Employee
                                            </a>
                                        </li>
                                        <li class="{{ request()->routeIs('user.create')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('user.create')}}">
                                                <i class="metismenu-icon">
                                                </i>Add Employee
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole
                            <li>
                                <a href="#">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                        Leave Management
                                </a>
                                <ul>  
                                    @role('admin')
                                        <li class="{{ request()->routeIs('leave.index')  ? 'mm-active'  : ''}}">
                                            <a href="{{route('leave.index')}}">
                                                <i class="metismenu-icon">
                                                </i>All Leave Requests
                                            </a>
                                        </li>
                                        <li class=" {{ request()->routeIs('leave.manager')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('leave.manager')}}">
                                                <i class="metismenu-icon">
                                                </i>Manager Leave Request
                                            </a>
                                        </li> 
                                     @endrole
                                    @hasanyrole('employee|HR|manager')
                                        <li class=" {{ request()->routeIs('leave.create')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('leave.create')}}">
                                                <i class="metismenu-icon">
                                                </i>Leave Request
                                            </a>
                                        </li> 
                                        <li class=" {{ request()->routeIs('user.leave.index')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('user.leave.index')}}">
                                                <i class="metismenu-icon">
                                                </i>My Leave Request
                                            </a>
                                        </li> 
                                    @endhasanyrole 
                                    @role('admin')
                                        <li class=" {{ request()->routeIs('leave.balance')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('leave.balance')}}">
                                                <i class="metismenu-icon">
                                                </i> Leave Balance
                                            </a>
                                        </li> 
                                    @endrole
                                    @role('manager')
                                        <li class=" {{ request()->routeIs('request.index')  ? 'mm-active'  : '' }}">
                                            <a href="{{ route('request.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Department Leave Request
                                            </a>
                                        </li> 
                                    @endrole                               
                                </ul>
                            </li> 
                                                   
                                <li>
                                    <a href="#">
                                        <i class="fa fa-sticky-note" aria-hidden="true"></i>
                                            Attendance
                                    </a>
                                    <ul>
                                        @role('admin')
                                            <li class=" {{ request()->routeIs('admin.attendance.index')  ? 'mm-active'  : '' }}">
                                                <a href="{{ route('admin.attendance.index') }}">
                                                    <i class="metismenu-icon">
                                                    </i>All Attendance
                                                </a>
                                            </li> 
                                        @endrole
                                        @role('HR') 
                                            <li class=" {{ request()->routeIs('attendance.index')  ? 'mm-active'  : '' }}">
                                                <a href="{{ route('attendance.index') }}">
                                                    <i class="metismenu-icon">
                                                    </i>All Attendance
                                                </a>
                                            </li> 
                                            <li class=" {{ request()->routeIs('attendance.create',auth()->user()->id)  ? 'mm-active'  : '' }}">
                                                <a href="{{ route('attendance.create',auth()->user()->id) }}">
                                                    <i class="metismenu-icon">
                                                    </i>Make Attendance
                                                </a>
                                            </li>
                                        @endrole
                                            <li class=" {{ request()->routeIs('employee.attendance.index')  ? 'mm-active'  : '' }}">
                                                <a href="{{ route('employee.attendance.index') }}">
                                                    <i class="metismenu-icon">
                                                    </i>My Attendance
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            <li>
                                <a href="#">
                                    <!-- <i class="metismenu-icon pe-7s-display2"></i> -->
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        Payroll
                                    <!-- <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> -->
                                </a>
                                <ul>
                                    @role('HR')
                                        <li class="{{ request()->routeIs('hr.salary.index')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('hr.salary.index')}}">
                                                <i class="metismenu-icon">
                                                </i>Department Salary
                                            </a>
                                        </li>
                                    @endrole
                                    @role('admin')
                                        <li class="{{ request()->routeIs('salary.index')  ? 'mm-active'  : '' }}">
                                            <a href="{{route('salary.index')}}">
                                                <i class="metismenu-icon">
                                                </i>All Salary
                                            </a>
                                        </li>
                                    @endrole
                                        <li class="{{ request()->routeIs('employee.salary.index')  ? 'mm-active'  : '' }}">
                                            <a href="{{ route('employee.salary.index') }}">
                                                <i class="metismenu-icon">
                                                </i>My Salary
                                            </a>
                                        </li>
                                </ul>
                            </li> 
                            @role('admin')
                                <li>
                                    <a href="#">
                                        <i class="fa-solid fa-user"></i>
                                            Role&Permission
                                        <!-- <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> -->
                                    </a>
                                    <ul>
                                        <li class=" {{request()->routeIs('role.index')  ? 'mm-active'  : ''}}">
                                            <a href="{{route('role.index')}}">
                                                <i class="metismenu-icon">
                                                </i>Role
                                            </a>
                                        </li>                                  
                                    </ul>
                                </li>
                            @endrole
                        </ul>
                    </div>
                </div>
            </div> 