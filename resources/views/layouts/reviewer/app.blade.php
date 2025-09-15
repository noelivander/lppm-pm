<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'ITH') }}</title>

        <!-- Fonts -->
        <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <style>
        #sidebarToggleTop {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            left: 250px;
            z-index: 1030;
            width: 32px;
            height: 64px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0 8px 8px 0;
        }
        body.sidebar-toggled #sidebarToggleTop { left: 90px; }
        .sidebar-avatar { width: 40px; height: 40px; aspect-ratio: 1 / 1; object-fit: cover; border-radius: 50% !important; flex-shrink: 0; }
        .sidebar-user-link img { border-radius: 50% !important; }
        body.sidebar-toggled .sidebar-user-text { display: none !important; }
        body.sidebar-toggled .sidebar-user-link { justify-content: center; }
        </style>
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            @include('layouts.reviewer.side-bar')
            
            <button id="sidebarToggleTop" class="btn btn-primary" style="position: fixed; top: 50%; transform: translateY(-50%); left: 250px; z-index: 1030; width: 32px; height: 64px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 0 8px 8px 0;">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                
                <!-- Main Content -->
                <div id="content">

                    <!-- Begin Page Content -->
                    <div class="container-fluid mt-3">

                        {{ $slot }}

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                @if(empty($hideFooter) || !$hideFooter)
                @include('layouts.reviewer.footer')
                @endif

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        {{ $modals ?? '' }}

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Scripts -->
        <script src="{{ mix('js/jquery.min.js') }}" defer></script>
        <script src="{{ mix('js/jquery.easing.min.js') }}" defer></script>
        <script src="{{ mix('js/bootstrap.bundle.min.js') }}" defer></script>
        <script src="{{ asset('js/reviewer.js') }}" defer></script>

        {{ $scripts ?? '' }}

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('sidebarToggleTop');
            var positionToggle = function() {
                var sidebar = document.getElementById('accordionSidebar');
                if (!btn || !sidebar) return;
                var rect = sidebar.getBoundingClientRect();
                btn.style.left = rect.right + 'px';
            };
            positionToggle();
            window.addEventListener('resize', positionToggle);
            if (btn) {
                btn.addEventListener('click', function() {
                    setTimeout(positionToggle, 350);
                });
            }
        });
        </script>

    </body>
</html>
