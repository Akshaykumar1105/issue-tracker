<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto mt-2">

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <div class="dropdown mr-5">

                <div class="user-panel  d-flex" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="image">
                        <div style=" padding: 20px;
                        background-size: cover; background-image: url('@if (isset(auth()->user()->getMedia('user')->first()->filename)) {{ asset('storage/user/' .auth()->user()->getMedia('user')->first()->filename .'.' .auth()->user()->getMedia('user')->first()->extension) }}');"
                            @else{{ asset('storage/user/user.png') }}');" @endif
                            class="img-circle
                            elevation-2" alt="User Image"></div>
                    </div>
                    <div class="info">
                        <a href="#" style="text-decoration: none; color: #000;"
                            class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item {{ in_array(Route::currentRouteName(), ['admin.profile.index', 'hr.profile.index', 'manager.profile.index']) ? 'active' : '' }}"
                            href="@if (auth()->user()->hasRole('admin')) {{ route('admin.profile.index') }} @elseif(auth()->user()->hasRole('hr')) {{ route('hr.profile.index') }}@elseif(auth()->user()->hasRole('manager')) {{ route('manager.profile.index') }} @endif">My
                            Profile</a>
                    </li>
                    <li>
                        <button type="submit" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#logoutModel">Logout</button>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>

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
                    <li class="nav-item  {{ Route::currentRouteName() == 'admin.dashboard' ? 'menu-open' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link  ">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>{{ __('messages.admin.dashboard') }}</p>
                        </a>

                    </li>
                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['admin.company.index', 'admin.company.edit']) ? 'menu-open' : '' }}">
                        <a href="{{ route('admin.company.index') }}" class="nav-link ">
                            <i class="fas fa-building"></i>
                            <p>{{ __('messages.admin.company') }}</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['admin.manager.index' , 'admin.hr.create' ,  'admin.hr.index', 'admin.hr.edit', 'admin.manager.edit', 'admin.manager.create']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), ['admin.manager.index', 'admin.hr.index', 'admin.hr.edit', 'admin.manager.edit'])  ? 'active' : '410' }} ">
                            <i class="fas fa-users"></i>
                            <p>
                                {{ __('messages.admin.user') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ in_array(Route::currentRouteName(), ['admin.hr.index', 'admin.hr.edit' , 'admin.hr.create', 'admin.manager.index', 'admin.manager.edit', 'admin.manager.create']) ? 'display: block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.hr.index') }}" style=""
                                    class="nav-link {{ in_array(Route::currentRouteName(), ['admin.hr.index', 'admin.hr.create', 'admin.hr.edit']) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Hr</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.manager.index') }}"
                                    class="nav-link {{ in_array(Route::currentRouteName(), ['admin.manager.index', 'admin.manager.create', 'admin.manager.edit']) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Manager</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['admin.issue.index', 'admin.issue.show']) ? 'menu-open' : '' }}">
                        <a href="{{ route('admin.issue.index') }}" class="nav-link">
                            <i class="fas fa-bug"></i>
                            <p>{{ __('messages.admin.issue') }}</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['admin.discount-coupon.index', 'admin.discount-coupon.create', 'admin.discount-coupon.edit']) ? 'menu-open' : '' }}">
                        <a href="{{ route('admin.discount-coupon.index') }}" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <p>Coupon</p>
                        </a>
                    </li>
                @endrole

                @role('hr')
                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['hr.dashboard']) ? 'menu-open' : '' }}">
                        <a href="{{ route('hr.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['hr.manager.index', 'hr.manager.edit']) ? 'menu-open' : '' }}">
                        <a href="{{ route('hr.manager.index') }}" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <p>Managers</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['hr.issue.index', 'hr.issue.edit']) ? 'menu-is-opening  manu-open' : '' }}">
                        <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), ['hr.issue.index', 'hr.issue.edit']) ? 'active' : '' }}">
                            <i class="fas fa-bug"></i>
                            <p>Issues<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ in_array(Route::currentRouteName(), ['hr.issue.index', 'hr.issue.edit']) ? 'display: block;' : '' }}">
                            <li class="nav-item {{ Route::currentRouteName() == 'hr.issue.index' ? 'active' : '410' }} ">
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
                                    class="nav-link {{ request('type') === 'all-issue' || Route::currentRouteName() == 'hr.issue.edit' ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>All Issue</p>
                                 </a>
                            </li>
                        </ul>
                    </li>
                @endrole

                @role('manager')
                    <li class="nav-item {{ Route::currentRouteName() == 'manager.dashboard' ? 'menu-open' : '' }}">
                        <a href="{{ route('manager.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Route::currentRouteName() == 'manager.issue.index' || Route::currentRouteName() == 'manager.issue.edit' ? 'menu-is-opening manu-open ' : '410' }}">
                        <a href="#" class="nav-link  {{ Route::currentRouteName() == 'manager.issue.index' || Route::currentRouteName() == 'manager.issue.edit' ? 'active' : '410' }} ">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Issues<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ in_array(Route::currentRouteName(), ['manager.issue.index', 'manager.issue.edit']) ? 'display: block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('manager.issue.index', ['type' => 'pending']) }}"
                                    class="nav-link {{ request('type') === 'pending' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending Issue</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manager.issue.index', ['type' => 'all-issue']) }}"
                                    class="nav-link {{ Route::currentRouteName() == 'manager.issue.edit' ? 'active' : '' }} {{  request('type') === 'all-issue' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Issue</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole
            </ul>
        </nav>
    </div>
</aside>
<div class="modal fade" id="logoutModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Log-Out</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to logout!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="logout" class="btn btn-danger">Logout</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '#logout', function(e) {
            e.preventDefault();
            $("#logoutModel").modal("toggle");
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('logout') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                success: function(response) {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                    }
                    toastr.success(response.success);
                    setTimeout(function() {
                        window.location.href = response.route;
                    }, 2000);
                }
            })
        })
    })
</script>
