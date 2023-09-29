<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="
    text-decoration: none;">
        <img src="{{ asset('/asset/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Issue Tracker</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->


        <!-- SidebarSearch Form -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @role('admin')
                    <li class="nav-item  {{ Request::is('admin/dashboard*') ? 'menu-open' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link  ">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{{ __('messages.admin.dashboard') }}</p>
                        </a>

                    </li>
                    <li class="nav-item {{ Request::is('admin/company*') ? 'menu-open' : '' }}">
                        <a href="{{ route('admin.company.index') }}" class="nav-link ">
                            <i class="nav-icon fas fa-th"></i>
                            <p>{{ __('messages.admin.company') }}</p>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ Request::is('admin/user*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{__(('messages.admin.user'))}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ Request::is('admin/user*') ? 'display: block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.user.index', ['listing' => 'hr']) }}" style="" class="nav-link {{ request('listing') === 'hr' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Hr</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.user.index', ['listing' => 'manager']) }}" class="nav-link {{ request('listing') === 'manager' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Manager</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::is('admin/issue*') ? 'menu-open ' : '' }}">
                        <a href="{{ route('admin.issue.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>{{ __('messages.admin.issue') }}</p>
                        </a>
                    </li>
                @endrole

                @role('hr')
                    <li class="nav-item {{ Request::is('hr/dashboard') ? 'menu-open' : '' }}">
                        <a href="{{ route('hr.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('hr/manager*') ? 'menu-open' : '' }}">
                        <a href="{{ route('hr.manager.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Managers</p>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ Request::is('hr/issue*') ? 'manu-open menu-is-opening ' : '' }}">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Issues
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ Request::is('hr/issue*') ? 'display: block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('hr.issue.index', ['listing' => 'pending']) }}" class="nav-link {{ request()->fullUrlIs('http://127.0.0.1:8000/hr/issue?listing=pending') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending Issue</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hr.issue.index', ['listing' => 'all-issue']) }}" class="nav-link {{ request()->fullUrlIs('http://127.0.0.1:8000/hr/issue?listing=all-issue') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Issue</p>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                @endrole

                @role('manager')
                    <li class="nav-item {{ Request::is('manager/dashboard*') ? 'menu-open' : '' }}"">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('manager/issue*') ? 'menu-open' : '' }}"">
                        <a href="{{ route('manager.issue.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Issues</p>
                        </a>
                    </li>
                @endrole

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
