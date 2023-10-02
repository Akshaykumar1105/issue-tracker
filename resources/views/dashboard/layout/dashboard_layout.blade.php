<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>Issue Tracker| Dashboard</title>
    @include('dashboard.layout.includes.style')
    @yield('style')
    <script src="{{ asset('/asset/plugins/jquery/jquery.min.js') }}"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto mt-2">

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <div class="dropdown mr-5">

                        <div class="user-panel  d-flex" id="profileDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="image">
                                <div style=" padding: 20px;
                                background-size: cover; background-image: url('@if(isset(auth()->user()->getMedia('user')->first()->filename)){{ asset('storage/user/' .auth()->user()->getMedia('user')->first()->filename .'.' .auth()->user()->getMedia('user')->first()->extension) }}');"
                                    @else{{ asset('/asset/dist/img/AdminLTELogo.png') }}
                                @endif
                                    class="img-circle elevation-2" alt="User Image"></div>
                            </div>
                            <div class="info">
                                <a href="#" style="text-decoration: none; color: #000;" class="d-block">{{ auth()->user()->name }}</a>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item " href="@if(auth()->user()->hasRole('admin')){{ route('admin.profile.index') }} @elseif(auth()->user()->hasRole('hr')) {{ route('hr.profile.index') }}@elseif(auth()->user()->hasRole('manager')) {{ route('manager.profile.index') }}@endif" >My Profile</a>
                            </li>
                            <li>
                                <button type="submit" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#logoutModel">Logout</button>
                                {{-- <a id="logout" class="dropdown-item">Logout</a> --}}
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('dashboard.layout.sidebar')

        <!--dashboard Container -->
        <div class="content-wrapper">
            @yield('content')
        </div>


    </div>

    <!-- Button trigger modal -->
    

    <!-- Modal -->
    <div class="modal fade" id="logoutModel" tabindex="-1"  aria-hidden="true">
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

    @include('dashboard.layout.includes.script')
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
                        'X-CSRF-TOKEN': csrfToken, // Send CSRF token as a header
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
    @yield('script')
</body>

</html>
</body>
