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
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            @include('layouts.dosen.side-bar')
            
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                
                <!-- Main Content -->
                <div id="content">

                    @include('layouts.dosen.nav-bar')

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        {{ $slot }}

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                @include('layouts.dosen.footer')

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
