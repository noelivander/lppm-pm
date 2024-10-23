<!-- Navbar & Hero Start -->
<div class="container position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="{{ route('home') }}" class="navbar-brand p-0">
            <div class="m-0 d-inline-flex p-2">
                <img src="{{ asset('Logo.png')}}" alt="Logo" class="">
                <p class="mb-0 align-self-end" style="line-height:0.9;">
                    <span class="h4">{{__($project_name)}}</span> <br>
                    <span><small class="font-weight-light">{{ __($institut_name) }}</small></span>
                </p>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Kelembagaan</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{ route('kelembagaan_tentang') }}" class="dropdown-item">Tentang</a>
                        <a href="{{ route('kelembagaan_visi_misi') }}" class="dropdown-item">Visi Misi</a>
                        <a href="{{ route('kelembagaan_struktur_organisasi') }}" class="dropdown-item">Struktur Organisasi</a>
                    </div>
                </div>
                @if(count($daftar_fokus_bidang)!=0)
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Bidang Fokus</a>
                    <div class="dropdown-menu m-0">
                        @foreach($daftar_fokus_bidang as $key => $value)
                            <a href="{{ route('bidang-fokus.show',['slug'=>$value->slug]) }}" class="dropdown-item">{{$value->nama}}</a>
                        @endforeach
                    </div>
                </div>
                @endif
                <!-- <a href="{{ route('penelitian.index') }}" class="nav-item nav-link">Penelitian</a> -->
                <!-- <a href="{{ route('pengabdian.index') }}" class="nav-item nav-link">Pengabdian</a> -->
                <a href="{{ route('dokumen.index') }}" class="nav-item nav-link">Dokumen</a>
                <a href="{{ route('layanan-berita.index') }}" class="nav-item nav-link">Berita</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{ route('layanan-agenda.index') }}" class="dropdown-item">Agenda</a>
                        <a href="{{ route('layanan-pengumuman.index') }}" class="dropdown-item">Pengumuman</a>
                    </div>
                </div>
            </div>
            <butaton type="button" class="btn text-secondary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></butaton>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3" href="{{ route('logout') }}" data-bs-toggle="modal" data-target="#logoutModal"   onclick="event.preventDefault();
                            this.closest('form').submit();">
                        Logout
                    </a>
                </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Login</a>
            @endauth
        </div>
    </nav>
</div>
<!-- Navbar & Hero End -->