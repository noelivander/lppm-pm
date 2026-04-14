<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'ITH') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('Logo.png') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css?family=nunito:200,300,400,600,700,800,900"
        integrity="sha384-GonvdRGaubFqBUbIL5dyw6iHNbubiMgMfmva54hYSEyooMmYF3KxaQvzHF7Qtb1d" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900"
        integrity="sha384-ByPDzzPuqqPoBRmbRo0zLTWfdqRp3cYLABq+81pkYw5JQ8TQnnLxi6gFifc2xscY" crossorigin="anonymous">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modern-components.css') }}">
        <style>
        body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif !important; }
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
        /* Page background */
        html, body, #content-wrapper, #content { background-color: #f3f4f6; }
        /* Strong dark text for main content */
        body, #content-wrapper, #content { color: #111 !important; }
        h1, h2, h3, h4, h5, h6 { color: #111 !important; }
        .text-gray-800, .text-gray-900 { color: #111 !important; }
        /* Tables: comfortable dark text */
        #content .table, #content table { color: #1a1a1a !important; }
        #content .table thead th { color: #1a1a1a !important; }
        #content .table td, #content .table th { vertical-align: middle; }
        /* Center main content area */
        #content > .container-fluid { max-width: 100% !important; margin-left: 0; margin-right: 0; padding-left: 0rem; padding-right: 1rem; }
        #content > .container-fluid.mt-3 { padding-left: 0rem; padding-right: 1rem; }
        /* Sidebar width control */
        #accordionSidebar.sidebar-modern { width: 260px !important; transition: width .25s ease; }
        body.sidebar-toggled #accordionSidebar.sidebar-modern { width: 90px !important; }
        /* Shift only the content area, not the whole body */
        #content-wrapper { margin-left: 280px; transition: margin-left .25s ease; overflow: visible !important; }
        body.sidebar-toggled #content-wrapper { margin-left: 90px; }
        /* Collapsed: icons-only navigation, brand icon only, profile avatar only, logout icon only */
        body.sidebar-toggled #accordionSidebar .sidebar-brand-text { display: none !important; }
        body.sidebar-toggled #accordionSidebar .sidebar-brand { justify-content: center !important; align-items: center !important; padding-left: 0 !important; padding-right: 0 !important; }
        body.sidebar-toggled #accordionSidebar .sidebar-brand .sidebar-brand-icon { margin: 0 !important; display: flex !important; width: 100% !important; justify-content: center !important; }
        body.sidebar-toggled #accordionSidebar .sidebar-brand .sidebar-brand-icon img { display: block; margin: 0 auto !important; }
        /* Nav items: keep visible but icon-only, remove bg */
        body.sidebar-toggled #accordionSidebar .nav-link span { display: none !important; }
        body.sidebar-toggled #accordionSidebar .nav-link { justify-content: center; gap: 0; padding: .6rem; background: transparent !important; border-color: transparent !important; box-shadow: none !important; width: 48px; max-width: 48px; margin-left: auto; margin-right: auto; }
        body.sidebar-toggled #accordionSidebar .sidebar-heading { display: none !important; }
        body.sidebar-toggled #accordionSidebar .sidebar-divider { margin: .35rem .5rem; }
        body.sidebar-toggled #accordionSidebar .collapse { display: none !important; }
        /* Profile block */
        body.sidebar-toggled #accordionSidebar .sidebar-user-text { display: none !important; }
        body.sidebar-toggled #accordionSidebar .sidebar-user-link { justify-content: center; background: transparent !important; border-color: transparent !important; width: 48px; max-width: 48px; margin-left: auto; margin-right: auto; padding: .4rem; }
        /* Logout button: icon-only */
        body.sidebar-toggled #accordionSidebar form .btn.w-100 span { display: none !important; }
        body.sidebar-toggled #accordionSidebar form .btn.w-100 { width: 48px !important; max-width: 48px; margin-left: auto; margin-right: auto; padding: .5rem !important; display: flex; align-items: center; justify-content: center; background: transparent !important; border-color: transparent !important; box-shadow: none !important; }
        body.sidebar-toggled #sidebarToggleTop { left: 90px; }
        .sidebar-avatar { width: 40px; height: 40px; aspect-ratio: 1 / 1; object-fit: cover; border-radius: 50% !important; flex-shrink: 0; }
        .sidebar-user-link img { border-radius: 50% !important; }
        body.sidebar-toggled .sidebar-user-text { display: none !important; }
        /* Global purple theme overrides */
        :root { --bs-primary: #7c3aed; --bs-primary-rgb: 124,58,237; }
        .btn-primary { background-color: var(--bs-primary) !important; border-color: var(--bs-primary) !important; }
        .btn-primary:hover, .btn-primary:focus { background-color: #6d28d9 !important; border-color: #6d28d9 !important; }
        .btn-outline-primary { color: var(--bs-primary) !important; border-color: var(--bs-primary) !important; }
        .btn-outline-primary:hover, .btn-outline-primary:focus { background-color: var(--bs-primary) !important; color: #fff !important; }
        .bg-primary { background-color: var(--bs-primary) !important; }
        .text-primary { color: var(--bs-primary) !important; }
        .badge-primary, .badge.bg-primary { background-color: var(--bs-primary) !important; }
        .progress-bar.bg-primary { background-color: var(--bs-primary) !important; }
        .border-left-primary { border-left: .25rem solid var(--bs-primary) !important; }
        .border-bottom-primary { border-bottom: .25rem solid var(--bs-primary) !important; }
        /* Spacing to keep profile and logout separated */
        #accordionSidebar .sidebar-user-link { margin-bottom: .5rem !important; }
        #accordionSidebar li.nav-item > form { margin-top: .5rem !important; display: block !important; }
        body.sidebar-toggled #accordionSidebar .sidebar-user-link .sidebar-avatar { margin-right: 0 !important; }
        body.sidebar-toggled .sidebar-user-link { justify-content: center; }
        </style>
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            @include('layouts.auditor.side-bar')
            
            <button id="sidebarToggleTop" class="btn btn-primary" style="position: fixed; top: 50%; transform: translateY(-50%); left: 250px; z-index: 1030; width: 32px; height: 64px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 0 8px 8px 0;">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                
                <!-- Main Content -->
                <div id="content">

                    <!-- Begin Page Content -->
                    <div class="container-fluid mt-4">

                        {{ $slot }}

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                @if(empty($hideFooter) || !$hideFooter)
                @include('layouts.auditor.footer')
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
        <script src="{{ asset('js/auditor.js') }}" defer></script>

        {{ $scripts ?? '' }}

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('sidebarToggleTop');
            var bodyEl = document.body;
            var breakpoint = 992; // px
            var applyResponsiveSidebar = function() {
                if (window.innerWidth <= breakpoint) {
                    if (!bodyEl.classList.contains('sidebar-toggled')) bodyEl.classList.add('sidebar-toggled');
                } else {
                    if (bodyEl.classList.contains('sidebar-toggled')) bodyEl.classList.remove('sidebar-toggled');
                }
            };
            var positionToggle = function() {
                var sidebar = document.getElementById('accordionSidebar');
                if (!btn || !sidebar) return;
                var rect = sidebar.getBoundingClientRect();
                btn.style.left = rect.right + 'px';
            };
            applyResponsiveSidebar();
            positionToggle();
            window.addEventListener('resize', function() {
                applyResponsiveSidebar();
                positionToggle();
            });
            if (btn) {
                btn.addEventListener('click', function() {
                    setTimeout(positionToggle, 350);
                });
            }
        });
        </script>

    </body>
</html>
