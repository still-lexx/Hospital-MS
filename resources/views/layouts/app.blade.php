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

    <!-- Global Skeleton Loader -->
    <style>
        /* ── Overlay ───────────────────────────────────────── */
        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(247, 249, 252, 0.96);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            transition: opacity 0.35s ease, visibility 0.35s ease;
            opacity: 1;
            visibility: visible;
        }
        #page-loader.sk-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* ── Top progress bar ──────────────────────────────── */
        #page-loader .sk-progress {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg,
                transparent 0%,
                #4cc38a 40%,
                #3490dc 70%,
                transparent 100%);
            background-size: 200% 100%;
            animation: sk-slide 1.4s linear infinite;
        }

        /* ── Centre card ───────────────────────────────────── */
        #page-loader .sk-card {
            width: 100%;
            max-width: 560px;
            background: #fff;
            border-radius: 10px;
            padding: 28px 32px;
            box-shadow: 0 6px 30px rgba(0,0,0,0.08);
        }

        /* ── Skeleton lines ────────────────────────────────── */
        .sk-line {
            height: 13px;
            border-radius: 6px;
            background: linear-gradient(90deg,
                #e8ecf0 25%,
                #d2d9e0 50%,
                #e8ecf0 75%);
            background-size: 400% 100%;
            animation: sk-shimmer 1.4s ease-in-out infinite;
        }
        .sk-line.sk-title  { height: 18px; width: 55%; margin-bottom: 20px; }
        .sk-line.sk-w-100  { width: 100%; margin-bottom: 12px; }
        .sk-line.sk-w-80   { width: 80%;  margin-bottom: 12px; }
        .sk-line.sk-w-60   { width: 60%;  margin-bottom: 12px; }
        .sk-line.sk-w-40   { width: 40%;  margin-bottom: 0; }

        /* ── 4-column stat cards row ───────────────────────── */
        .sk-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        .sk-stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }
        .sk-stat-card .sk-icon {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: linear-gradient(90deg, #e8ecf0 25%, #d2d9e0 50%, #e8ecf0 75%);
            background-size: 400% 100%;
            animation: sk-shimmer 1.4s ease-in-out infinite;
            margin-bottom: 12px;
        }

        /* ── Animations ────────────────────────────────────── */
        @keyframes sk-shimmer {
            0%   { background-position: 100% 50%; }
            100% { background-position:   0% 50%; }
        }
        @keyframes sk-slide {
            0%   { background-position: 200% 0; }
            100% { background-position:  -200% 0; }
        }

        @media (max-width: 640px) {
            .sk-stats-row { grid-template-columns: repeat(2, 1fr); }
            #page-loader .sk-card { margin: 0 16px; padding: 20px; }
        }
    </style>
</head>
<body>

    <!-- ═══════════ Global Page Loader ═══════════ -->
    <div id="page-loader">
        <div class="sk-progress"></div>

        <!-- Mini stat-card row -->
        <div class="sk-stats-row" style="width:100%;max-width:560px;margin-bottom:16px;">
            <div class="sk-stat-card">
                <div class="sk-icon"></div>
                <div class="sk-line sk-w-60"></div>
                <div class="sk-line sk-w-40" style="margin-top:8px;"></div>
            </div>
            <div class="sk-stat-card">
                <div class="sk-icon"></div>
                <div class="sk-line sk-w-60"></div>
                <div class="sk-line sk-w-40" style="margin-top:8px;"></div>
            </div>
            <div class="sk-stat-card">
                <div class="sk-icon"></div>
                <div class="sk-line sk-w-60"></div>
                <div class="sk-line sk-w-40" style="margin-top:8px;"></div>
            </div>
            <div class="sk-stat-card">
                <div class="sk-icon"></div>
                <div class="sk-line sk-w-60"></div>
                <div class="sk-line sk-w-40" style="margin-top:8px;"></div>
            </div>
        </div>

        <!-- Content placeholder card -->
        <div class="sk-card">
            <div class="sk-line sk-title"></div>
            <div class="sk-line sk-w-100"></div>
            <div class="sk-line sk-w-80"></div>
            <div class="sk-line sk-w-100"></div>
            <div class="sk-line sk-w-60"></div>
            <div class="sk-line sk-w-80" style="margin-top:20px;"></div>
            <div class="sk-line sk-w-40"></div>
        </div>
    </div>
    <!-- ═══════════ END Global Page Loader ═══════════ -->
    
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
        @stack('scripts')

        <!-- ═══════════ Skeleton Loader Controller ═══════════ -->
        <script>
        (function () {
            var loader = document.getElementById('page-loader');
            if (!loader) return;

            /* ── Hide loader once THIS page is ready ─────────────── */
            function hideLoader() {
                loader.classList.add('sk-hidden');
                // fully remove from DOM after transition so it can't interfere
                setTimeout(function () {
                    if (loader.parentNode) loader.parentNode.removeChild(loader);
                }, 400);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', hideLoader);
            } else {
                hideLoader();           // already loaded (e.g. back-forward cache)
            }

            /* ── Show loader on outgoing navigations ─────────────── */
            function shouldShowLoader(el) {
                var href = el.getAttribute('href') || '';
                // Skip: no href, anchor-only, javascript:void, external, Bootstrap toggles
                if (!href || href === '#' || href.indexOf('javascript') === 0) return false;
                if (el.getAttribute('data-toggle')  ||
                    el.getAttribute('data-action')   ||
                    el.getAttribute('data-bs-toggle')) return false;
                // Skip external links
                if (href.indexOf('http') === 0 && href.indexOf(window.location.origin) !== 0) return false;
                return true;
            }

            document.addEventListener('click', function (e) {
                var link = e.target.closest('a');
                if (link && shouldShowLoader(link) && !e.ctrlKey && !e.metaKey && !e.shiftKey) {
                    showLoader();
                }
            });

            // Also show on form submissions (POST navigations)
            document.addEventListener('submit', function (e) {
                if (e.target && e.target.tagName === 'FORM' && e.target.method !== 'dialog') {
                    showLoader();
                }
            });

            function showLoader() {
                // Re-create loader if it was already removed (edge case)
                if (!document.getElementById('page-loader')) {
                    loader = createLoader();
                    document.body.appendChild(loader);
                }
                loader.classList.remove('sk-hidden');
            }

            function createLoader() {
                var d = document.createElement('div');
                d.id = 'page-loader';
                d.innerHTML = document.querySelector('#page-loader') ?
                    document.querySelector('#page-loader').innerHTML : '<div class="sk-progress"></div>';
                return d;
            }
        })();
        </script>
        <!-- ═══════════ END Skeleton Loader Controller ═══════════ -->
</body>
</html>
