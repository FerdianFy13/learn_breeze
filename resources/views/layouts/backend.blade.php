<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} || Nelayan Kita</title>

    {{-- icon --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('dist/images/logos/favicon.png') }}" />
    {{-- end icon --}}

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('dist/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/data_tables.css') }}" />
    <style>
        #formInsert .select2 {
            width: 100% !important;
        }
    </style>
    {{-- end css --}}

    {{-- cdn --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    {{-- end cdn --}}

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
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dist/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('dist/js/dashboard.js') }}"></script>
    <script src="{{ asset('dist/js/tables.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('dist/js/select.js') }}"></script>

</body>

</html>
