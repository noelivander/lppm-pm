<!-- Navbar & Hero Start -->
<div class="container position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-2 py-lg-0 glass-effect navbar-modern sticky-top" style="border-radius: 16px; margin-top: 12px; border: 1px solid rgba(79,70,229,.15); background: rgba(255,255,255,.96);">
        <a href="{{ route('home') }}" class="navbar-brand p-0 d-flex align-items-center">
            <img src="{{ asset('Logo.png')}}" alt="Logo" class="me-3" style="height:40px; width:auto;">
            <div class="mb-0" style="line-height:1;">
                <span class="h5 mb-0 gradient-text d-block">{{__($project_name)}}</span>
                <small class="text-muted">{{ __($institut_name) }}</small>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto py-0 align-items-lg-center" style="--bs-navbar-color: var(--text-primary);">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Kelembagaan</a>
                    <div class="dropdown-menu m-0 modern-card p-2" style="min-width: 220px; border-color: rgba(79,70,229,.2);">
                        <a href="{{ route('kelembagaan_tentang') }}" class="dropdown-item">Tentang</a>
                		<a href="{{ route('kelembagaan_visi_misi') }}" class="dropdown-item">Visi Misi</a>
                        <a href="{{ route('kelembagaan_struktur_organisasi') }}" class="dropdown-item">Struktur Organisasi</a>
                    </div>
                </li>
                @if(count($daftar_fokus_bidang)!=0)
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Bidang Fokus</a>
                    <div class="dropdown-menu m-0 modern-card p-2" style="min-width: 220px; max-height: 60vh; overflow:auto; border-color: rgba(37,99,235,.2);">
                        @foreach($daftar_fokus_bidang as $key => $value)
                            <a href="{{ route('bidang-fokus.show',['slug'=>$value->slug]) }}" class="dropdown-item">{{$value->nama}}</a>
                        @endforeach
                    </div>
                </li>
                @endif
                <li class="nav-item"><a href="{{ route('dokumen.index') }}" class="nav-link">Dokumen</a></li>
                <li class="nav-item"><a href="{{ route('layanan-berita.index') }}" class="nav-link">Berita</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan</a>
                    <div class="dropdown-menu m-0 modern-card p-2" style="min-width: 220px; border-color: rgba(79,70,229,.2);">
                        <a href="{{ route('layanan-agenda.index') }}" class="dropdown-item">Agenda</a>
                        <a href="{{ route('layanan-pengumuman.index') }}" class="dropdown-item">Pengumuman</a>
                    </div>
                </li>
            </ul>
            <div class="d-flex align-items-center ms-lg-3 mt-3 mt-lg-0">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="modern-btn modern-btn-primary"><i class="fa fa-sign-out-alt me-2"></i>Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="modern-btn modern-btn-primary"><i class="fa fa-user me-2"></i>Login</a>
                @endauth
            </div>
        </div>
    </nav>
</div>
<!-- Navbar & Hero End -->