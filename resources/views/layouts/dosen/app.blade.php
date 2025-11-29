<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'ITH') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('Logo.png') }}">

        <!-- Fonts -->
        <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modern-components.css') }}">
        <style>
        body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif !important; }
        :root {
            --sidebar-width-full: 280px;
            --bs-primary: #7c3aed;
            --bs-primary-rgb: 124,58,237;
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
        #content > .container-fluid { max-width: 100% !important; margin-left: 0; margin-right: 0; padding-left: 2rem; padding-right: 2rem; }
        #content > .container-fluid.mt-3 { padding-left: 2rem; padding-right: 2rem; }
        #content > .container-fluid > .container-fluid,
        #content > .container-fluid > .container {
            padding-left: 0;
            padding-right: 0;
        }
        /* Sidebar width control */
        #accordionSidebar.sidebar-modern { width: var(--sidebar-width-full) !important; transition: transform .25s ease, box-shadow .25s ease, width .25s ease; }
        body.sidebar-hidden #accordionSidebar.sidebar-modern,
        body.sidebar-toggled #accordionSidebar.sidebar-modern { transform: translateX(-105%); box-shadow: none; }
        /* Shift only the content area, not the whole body */
        #content-wrapper { margin-left: var(--sidebar-width-full); transition: margin-left .25s ease; overflow: visible !important; }
        body.sidebar-hidden #content-wrapper,
        body.sidebar-toggled #content-wrapper { margin-left: 0 !important; }
        .sidebar-avatar { width: 40px; height: 40px; aspect-ratio: 1 / 1; object-fit: cover; border-radius: 50% !important; flex-shrink: 0; }
        .sidebar-user-link img { border-radius: 50% !important; }
        /* Global purple theme overrides */
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
        @media (max-width: 1023.98px) {
            #content-wrapper { margin-left: 0 !important; }
            #content > .container-fluid,
            #content > .container-fluid.mt-3 {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }
            #content > .container-fluid > .container-fluid,
            #content > .container-fluid > .container {
                padding-left: 0;
                padding-right: 0;
            }
            body.sidebar-toggled #content-wrapper { margin-left: 0 !important; }
        }
        </style>
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            @include('layouts.dosen.side-bar')
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
                @include('layouts.dosen.footer')
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
        <script src="{{ asset('js/dosen.js') }}" defer></script>

        {{ $scripts ?? '' }}

    </body>
</html>
