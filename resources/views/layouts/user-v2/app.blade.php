<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? config('app.name', $project_name) }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Heebo:wght@400;500&display=swap"
    integrity="sha384-EGUtTluGInHz/ak87Vx0zqV/A/l0H2HyMgL3MgrTXovU82PYpCGZZX5vMahMbv8m" crossorigin="anonymous">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
    integrity="sha384-0c38nfCMzF8w8DBI+9nTWzApOpr1z0WuyswL4y6x/2ZTtmj/Ki5TedKeUcFusC/k" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    integrity="sha384-NUDU7Qr8dfscXBIhA0px/bRl3cgNrOT9l/WPm15DzH5xnBs4fL4vgRiXURs98/ID" crossorigin="anonymous">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('vendor/user/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/user/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/user/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern-components.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing-page.css') }}" rel="stylesheet">

    
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary spinner-size" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
        
        @include('layouts.user-v2.navbar')

        @if(isset($slot) && !empty(trim($slot)))
            {{ $slot }}
        @else
            @yield('content')
        @endif

        @include('layouts.user-v2.footer')

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"
        integrity="sha384-BxpSbjbDhVKwnC1UfcjsNEuMuxg4af5IXOaSi1Iq5rASQ/9a7uslhEXbP9UI/fXo"
        crossorigin="anonymous" defer></script>
    <script src="{{ asset('vendor/user/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('vendor/user/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('vendor/user/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('vendor/user/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/user/lib/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/user/lib/lightbox/js/lightbox.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/user-custom.js') }}"></script>
    <script src="{{ asset('js/landing.js') }}"></script>

</body>

</html>