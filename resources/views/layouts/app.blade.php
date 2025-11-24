<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

     <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset ('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset ('media/favicons/apple-touch-icon-180x180.png') }}">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Fonts and OneUI framework -->
    <link rel="stylesheet" href="{{asset('css/font.css')}}">
    <link rel="stylesheet" id="css-main" href="{{ asset ('css/oneui.min.css') }}">
    <link rel="stylesheet" href="{{asset ('js/plugins/dropzone/dist/min/dropzone.min.css')}}">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    
    @guest
        @include('layouts.header')
        <div class="content">
            @yield('content')
        </div>
    @else
    <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">     
        @include('layouts.aside')
        @include('layouts.sidebar')
        @include('layouts.header')
        <main id="main-container">
            <div class="main-content">
                    @yield('content')
            </div>
        </main>
        @include('layouts.footer')
        @endguest
    </div>

    <script src="{{asset ('js/oneui.core.min.js') }}"></script>

        <!--
            OneUI JS

            Custom functionality including Blocks/Layout API as well as other vital and optional helpers
            webpack is putting everything together at assets/_es6/main/app.js
        -->
        <script src="{{asset ('js/oneui.app.min.js') }}"></script>

        <!-- Page JS Plugins -->
        <script src="{{ asset ('js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset ('js/plugins/chart.js/Chart.bundle.min.js') }}"></script>
        <script src="{{ asset ('js/plugins/dropzone/dropzone.min.js') }}"></script>

        <!-- Page JS Code -->
        <script src="{{ asset ('js/pages/be_pages_dashboard.min.js') }}"></script>

        <!-- Page JS Helpers (jQuery Sparkline Plugins) -->
        <script>jQuery(function () { One.helpers(['sparkline']); });</script>
        
        <!-- Live Search -->
        <script src="{{ asset('js/live-search.js') }}"></script>
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- SweetAlert Global Implementation -->
        <script>
            // Display Laravel session messages as SweetAlert
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    timer: 3000
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true
                });
            @endif

            @if(session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: '{{ session('warning') }}',
                    showConfirmButton: true
                });
            @endif

            @if(session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: '{{ session('info') }}',
                    showConfirmButton: true
                });
            @endif

            // Global delete confirmation function
            function confirmDelete(event, formId) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }
        </script>
</body>
</html>
