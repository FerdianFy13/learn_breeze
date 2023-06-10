<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} || Modernize</title>

    {{-- icon --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('dist/images/logos/favicon.png') }}" />
    {{-- end icon --}}

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('dist/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/data_tables.css') }}">
    {{-- end css --}}

</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        {{-- sidebar --}}
        @section('sidebar_be')
        @include('components.sidebar-be')
        @show
        {{-- end sidebar --}}

        <div class="body-wrapper">
            {{-- navbar --}}
            @section('navigation_be')
            @include('components.navigation-be')
            @show
            {{-- end navbar --}}

            <div class="container-fluid">
                {{-- breadcrumb --}}
                @section('breadcrumb')
                @include('components.breadcrumb-be')
                @show
                {{-- end breadcrumb --}}

                {{-- content --}}
                @yield('backend_content')
                {{-- end content --}}

                {{-- footer --}}
                @section('footer_be')
                @include('components.footer-be')
                @show
                {{-- end footer --}}
            </div>
        </div>
    </div>
    <script src="{{ asset('dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}">
    </script>
    <script src="{{ asset('dist/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('dist/js/dashboard.js') }}"></script>
    <script src="{{ asset('dist/js/tables.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.bootstrap5.min.js') }}"></script>
</body>

</html>