<!-- Navbar & Hero Start -->
<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0 sticky-top shadow-sm" 
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05);">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand p-0 d-flex align-items-center">
                <img src="{{ asset('Logo.png')}}" alt="Logo" class="me-3" style="height:45px; width:auto;">
                <div class="mb-0" style="line-height:1.2;">
                    <span class="h5 mb-0 fw-bold text-primary d-block">{{__($project_name)}}</span>
                    <small class="text-secondary fw-medium" style="font-size: 0.85rem;">{{ __($institut_name) }}</small>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto py-0 align-items-lg-center">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown">Kelembagaan</a>
                        <div class="dropdown-menu m-0 shadow-sm border-0 rounded-3 p-2">
                            <a href="{{ route('kelembagaan_tentang') }}" class="dropdown-item rounded-2">Tentang</a>
                            <a href="{{ route('kelembagaan_visi_misi') }}" class="dropdown-item rounded-2">Visi Misi</a>
                            <a href="{{ route('kelembagaan_struktur_organisasi') }}" class="dropdown-item rounded-2">Struktur Organisasi</a>
                        </div>
                    </li>
                    @if(count($daftar_fokus_bidang)!=0)
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown">Bidang Fokus</a>
                        <div class="dropdown-menu m-0 shadow-sm border-0 rounded-3 p-2" style="max-height: 60vh; overflow-y: auto;">
                            @foreach($daftar_fokus_bidang as $key => $value)
                                <a href="{{ route('bidang-fokus.show',['slug'=>$value->slug]) }}" class="dropdown-item rounded-2">{{$value->nama}}</a>
                            @endforeach
                        </div>
                    </li>
                    @endif
                    <li class="nav-item"><a href="{{ route('dokumen.index') }}" class="nav-link fw-medium">Dokumen</a></li>
                    <li class="nav-item"><a href="{{ route('layanan-berita.index') }}" class="nav-link fw-medium">Berita</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown" data-bs-toggle="dropdown">Layanan</a>
                        <div class="dropdown-menu m-0 shadow-sm border-0 rounded-3 p-2">
                            <a href="{{ route('layanan-agenda.index') }}" class="dropdown-item rounded-2">Agenda</a>
                            <a href="{{ route('layanan-pengumuman.index') }}" class="dropdown-item rounded-2">Pengumuman</a>
                        </div>
                    </li>
                </ul>
                <div class="d-flex align-items-center ms-lg-4 mt-3 mt-lg-0">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm hover-transform">
                                <i class="fa fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm hover-transform">
                            <i class="fa fa-user me-2"></i>Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</div>

<style>
    .navbar-nav .nav-link {
        position: relative;
        transition: color 0.3s ease;
    }
    
    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: var(--bs-primary);
        transition: width 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover::after,
    .navbar-nav .nav-link.active::after {
        width: 100%;
    }

    .hover-transform {
        transition: transform 0.3s ease;
    }
    
    .hover-transform:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        }
    }
</style>
<!-- Navbar & Hero End -->