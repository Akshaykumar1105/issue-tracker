<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @role('admin')
                    <li class="nav-item  {{ Request::is('admin/dashboard*') ? 'menu-open' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link  ">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>{{ __('messages.admin.dashboard') }}</p>
                        </a>

                    </li>
                    <li class="nav-item {{ Request::is('admin/company*') ? 'menu-open' : '' }}">
                        <a href="{{ route('admin.company.index') }}" class="nav-link ">
                            <i class="fas fa-building"></i>
                            <p>{{ __('messages.admin.company') }}</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Request::is('admin/hr*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link ">
                            <i class="fas fa-users"></i>
                            <p>
                                {{ __('messages.admin.user') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ Request::is('admin/hr*') || Request::is('admin/manager*') ? 'display: block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.hr.index') }}" style=""
                                    class="nav-link {{ Request::is('admin/hr*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Hr</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.manager.index') }}"
                                    class="nav-link {{ Request::is('admin/manager*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Manager</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::is('admin/issue*') ? 'menu-open ' : '' }}">
                        <a href="{{ route('admin.issue.index') }}" class="nav-link">
                            <i class="fas fa-bug"></i>
                            <p>{{ __('messages.admin.issue') }}</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Request::is('admin/discount-coupon*') ? 'menu-open ' : '' }}">
                        <a href="{{ route('admin.discount-coupon.index') }}" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <p>Discount Coupon</p>
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
                            <i class="fas fa-user-tie"></i>
                            <p>Managers</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Request::is('hr/issue') ? 'menu-is-opening  manu-open' : '' }}">
                        <a href="#" class="nav-link ">
                            <i class="fas fa-bug"></i>
                            <p>Issues<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ Request::is('hr/issue*') ? 'display: block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('hr.issue.index', ['type' => 'pending']) }}"
                                    class="nav-link {{ request('type') === 'pending' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending Issue</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hr.issue.index', ['type' => 'review-issue']) }}"
                                    class="nav-link {{ request('type') === 'review-issue' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Review Issue</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hr.issue.index', ['type' => 'all-issue']) }}"
                                    class="nav-link {{ request('type') === 'all-issue' ? 'active' : '' }}">
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

                    <li class="nav-item {{ Request::is('manager/issue*') ? 'manu-open menu-is-opening' : '' }}">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Issues<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ Request::is('manager/issue*') ? 'display: block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('manager.issue.index', ['type' => 'pending']) }}"
                                    class="nav-link {{ request('type') === 'pending' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending Issue</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manager.issue.index', ['type' => 'all-issue']) }}"
                                    class="nav-link {{ request('type') === 'all-issue' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Issue</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endrole

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
