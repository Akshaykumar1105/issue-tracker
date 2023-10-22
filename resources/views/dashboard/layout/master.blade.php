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
    @stack('dropdown-css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Main Sidebar Container -->
        @include('dashboard.layout.sidebar')

        <!--dashboard Container -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    
    @include('dashboard.layout.includes.footer')

    @include('dashboard.layout.includes.script')
   
    @yield('script')
    @stack('dropdown-js')
</body>

</html>
</body>
