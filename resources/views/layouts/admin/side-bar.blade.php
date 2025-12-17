<!-- Sidebar -->
<style>
    :root {
        --sb-bg: #21163d;
        --sb-bg2: #352467;
        --sb-accent: #7c3aed;
        --sb-accent-2: #8b5cf6;
        --sb-text: #e5e7eb;
        --sb-text-dim: #9ca3af;
        --sb-active: #7c3aed;
    }

    .sidebar.sidebar-modern {
        background: linear-gradient(180deg, var(--sb-bg) 0%, var(--sb-bg2) 100%);
        color: var(--sb-text);
        padding: 0.7rem 0.85rem 0.5rem;
        width: var(--sidebar-width-full, 280px);
        box-shadow: inset 0 0 0 1px rgba(124, 58, 237, 0.15);
        border-right: 1px solid rgba(124, 58, 237, 0.18);
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        height: 100vh;
        overflow-y: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
        box-sizing: border-box;
        z-index: 1035;
        transition: transform .28s ease, box-shadow .28s ease, width .28s ease;
    }

    .sidebar.sidebar-modern::-webkit-scrollbar {
        width: 0;
        height: 0;
    }

    .sidebar.sidebar-modern .sidebar-brand {
        padding: .85rem .75rem;
        margin: .25rem .25rem 0.75rem;
        border-radius: 14px;
        background: radial-gradient(120% 120% at 0% 0%, rgba(124, 58, 237, .22) 0%, rgba(139, 92, 246, .18) 42%, rgba(255, 255, 255, 0.04) 100%);
        color: var(--sb-text);
        box-shadow: 0 4px 16px rgba(2, 6, 23, .25) inset, 0 6px 22px rgba(2, 6, 23, .35);
        position: relative;
    }

    .sidebar.sidebar-modern .sidebar-brand-icon {
        flex-shrink: 0;
    }

    .sidebar.sidebar-modern .sidebar-brand-text {
        font-weight: 700;
        letter-spacing: .4px;
        white-space: nowrap;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        color: var(--sb-text);
        line-height: 1.2;
    }

    .sidebar.sidebar-modern .sidebar-brand small {
        color: var(--sb-text-dim);
        font-weight: 500;
    }

    .sidebar.sidebar-modern .sidebar-divider {
        border-color: rgba(255, 255, 255, 0.06);
        margin: .65rem .5rem;
    }

    .sidebar.sidebar-modern .sidebar-heading {
        font-size: .72rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--sb-text-dim);
        padding: .25rem .75rem;
    }

    .sidebar.sidebar-modern .nav-item {
        margin: .15rem .25rem;
        width: calc(100% - .5rem);
    }

    .sidebar.sidebar-modern .nav-link {
        width: 100%;
        box-sizing: border-box;
        position: relative;
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .7rem .95rem;
        border-radius: 12px;
        color: var(--sb-text);
        background: rgba(255, 255, 255, 0.02);
        transition: all .18s ease;
        border: 1px solid transparent;
    }

    .sidebar.sidebar-modern .nav-link i {
        width: 1.25rem;
        text-align: center;
        color: var(--sb-text-dim);
    }

    .sidebar.sidebar-modern .nav-link span {
        flex: 1;
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar.sidebar-modern .nav-link:hover {
        background: rgba(124, 58, 237, 0.10);
        border-color: rgba(124, 58, 237, 0.28);
        box-shadow: 0 8px 20px rgba(124, 58, 237, .22);
        transform: translateY(-1px);
    }

    .sidebar.sidebar-modern .nav-item.active>.nav-link,
    .sidebar.sidebar-modern .nav-link.active {
        background: linear-gradient(90deg, rgba(124, 58, 237, .28) 0%, rgba(139, 92, 246, .25) 100%);
        border-color: rgba(139, 92, 246, .42);
        box-shadow: 0 10px 26px rgba(124, 58, 237, .25);
    }

    .sidebar.sidebar-modern .collapse-inner {
        background: rgba(255, 255, 255, 1) !important;
        border-radius: 12px;
        margin: .25rem .5rem .5rem;
        padding: .5rem;
        border: 1px dashed rgba(255, 255, 255, 0.07);
    }

    .sidebar.sidebar-modern .collapse-item {
        border-radius: 10px;
        padding: .5rem .65rem;
        color: var(--sb-text);
    }

    .sidebar.sidebar-modern .collapse-item:hover,
    .sidebar.sidebar-modern .collapse-item.active {
        background: rgba(255, 255, 255, 0.06);
    }

    .sidebar.sidebar-modern .collapse-item.disabled-link {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .sidebar-user-link {
        background: rgba(255, 255, 255, 0.03);
        padding: .7rem .85rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        transition: all .18s ease;
    }

    .sidebar-user-link:hover {
        background: rgba(255, 255, 255, 0.06);
        transform: translateY(-1px);
    }

    .sidebar-avatar {
        width: 42px;
        height: 42px;
        object-fit: cover;
        box-shadow: 0 6px 18px rgba(2, 6, 23, .35);
        border: 2px solid rgba(255, 255, 255, 0.15);
    }

    .sidebar-user-text .fw-bold {
        font-size: .95rem;
    }

    .sidebar .btn.btn-light.w-100 {
        background: linear-gradient(90deg, rgba(124, 58, 237, .18) 0%, rgba(139, 92, 246, .18) 100%);
        color: var(--sb-text);
        border: 1px solid rgba(139, 92, 246, 0.25);
        border-radius: 12px;
    }

    .sidebar .btn.btn-light.w-100:hover {
        background: linear-gradient(90deg, rgba(124, 58, 237, .28) 0%, rgba(139, 92, 246, .28) 100%);
        color: #fff;
        border-color: rgba(139, 92, 246, 0.38);
        box-shadow: 0 10px 30px rgba(124, 58, 237, .28);
    }

    #sidebarToggle {
        width: 34px;
        height: 34px;
        background: rgba(255, 255, 255, 0.06);
        color: var(--sb-text);
    }

    #sidebarToggle:hover {
        background: rgba(255, 255, 255, 0.12);
    }

    .sidebar-collapse-toggle {
        position: fixed;
        top: 50%;
        left: var(--sidebar-width-full, 320px);
        transform: translate(-50%, -50%);
        width: 38px;
        height: 38px;
        border-radius: 999px;
        border: none;
        background: #fff;
        color: var(--sb-bg);
        box-shadow: 0 12px 30px rgba(2, 6, 23, .25);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        z-index: 1036;
        transition: left .25s ease, background .2s ease, color .2s ease, transform .25s ease, box-shadow .25s ease;
    }

    .sidebar-collapse-toggle:hover {
        background: #f3f4f6;
        color: var(--sb-accent);
    }

    body.sidebar-hidden .sidebar-collapse-toggle {
        left: 0.5rem;
        transform: translate(-50%, -50%);
        background: var(--sb-accent);
        color: #fff;
        box-shadow: 0 12px 30px rgba(124, 58, 237, .45);
    }

    @media (max-width: 1023.98px) {
        .sidebar.sidebar-modern {
            width: var(--sidebar-width-full, 280px);
        }

        .sidebar.sidebar-modern .sidebar-brand {
            flex-direction: row;
            align-items: center;
        }

        .sidebar.sidebar-modern .sidebar-brand-icon {
            margin-bottom: 0;
            margin-right: 0.5rem !important;
        }

        .sidebar.sidebar-modern .sidebar-brand-text {
            position: absolute !important;
            transform: translateX(-50%) !important;
            left: 50% !important;
            text-align: center;
            width: auto;
            margin-top: 0;
            display: block !important;
        }

        .sidebar.sidebar-modern,
        .sidebar.sidebar-modern .nav-link,
        .sidebar.sidebar-modern .collapse-inner,
        .sidebar.sidebar-modern .collapse-item {
            text-align: left;
        }

        body:not(.sidebar-ready) #accordionSidebar.sidebar-modern {
            transform: translateX(-105%);
            transition: none !important;
        }
    }
</style>
<ul class="navbar-nav sidebar sidebar-dark accordion d-flex flex-column sidebar-modern" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ url('Logo.png') }}" height="36">
        </div>
        <div class="sidebar-brand-text">
            LPPM-PM
            <div><small>Admin</small></div>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @php
        $isAdminDashboard = request()->routeIs('admin.dashboard');
        $isKelolaUser = request()->routeIs('users.index');
        $isTimeline = request()->routeIs('admin.timeline.index');
    @endphp

    <li class="nav-item {{ $isAdminDashboard ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @php
        $isKelembagaanMenu = request()->routeIs('tentang-satker.index', 'visi-misi.index', 'struktur-organisasi.index');
        $isLayananMenu = request()->routeIs('agenda.index', 'berita.index', 'dokumen_penting.index', 'pengumuman.index');
        $isPengaturanUmumMenu = request()->routeIs('jurusan.index', 'program_studi.index', 'pegawai.index', 'related_link.index');
        $isPengaturanLppmMenu = request()->routeIs('skema.index', 'luaran.index', 'bidang-penelitian.index', 'rab.index', 'form-penilaian-laporan-kemajuan.index', 'form-penilaian-laporan-akhir.index', 'form-penilaian-review.index');
    @endphp

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ $isKelembagaanMenu ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKelembagaan"
            aria-expanded="{{ $isKelembagaanMenu ? 'true' : 'false' }}" aria-controls="collapseKelembagaan">
            <i class="fas fa-fw fa-university"></i>
            <span>Kelembagaan</span>
            <i class="fas fa-angle-down ms-auto small"></i>
        </a>
        <div id="collapseKelembagaan" class="collapse {{ $isKelembagaanMenu ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @isroute('tentang-satker.index')"
                    href="{{ route('tentang-satker.index') }}">Tentang</a>
                <a class="collapse-item @isroute('visi-misi.index')" href="{{ route('visi-misi.index') }}">Visi Misi</a>
                <a class="collapse-item @isroute('struktur-organisasi.index')"
                    href="{{ route('struktur-organisasi.index') }}">Struktur Organisasi</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ $isLayananMenu ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayanan"
            aria-expanded="{{ $isLayananMenu ? 'true' : 'false' }}" aria-controls="collapseLayanan">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Layanan</span>
            <i class="fas fa-angle-down ms-auto small"></i>
        </a>
        <div id="collapseLayanan" class="collapse {{ $isLayananMenu ? 'show' : '' }}" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @isroute('admin.landing-page.index')"
                    href="{{ route('admin.landing-page.index') }}">Landing Page</a>
                <a class="collapse-item @isroute('agenda.index')" href="{{ route('agenda.index') }}">Agenda</a>
                <a class="collapse-item @isroute('berita.index')" href="{{ route('berita.index') }}">Berita</a>
                <a class="collapse-item @isroute('dokumen_penting.index')"
                    href="{{ route('dokumen_penting.index') }}">Dokumen</a>
                <a class="collapse-item @isroute('pengumuman.index')"
                    href="{{ route('pengumuman.index') }}">Pengumuman</a>
                <a class="collapse-item @isroute('related_link.index')"
                    href="{{ route('related_link.index') }}">Tautan</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pengaturan Collapse Menu -->
    <li class="nav-item {{ $isPengaturanUmumMenu ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilitiesUmum"
            aria-expanded="{{ $isPengaturanUmumMenu ? 'true' : 'false' }}" aria-controls="collapseUtilitiesUmum">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pengaturan</span>
            <i class="fas fa-angle-down ms-auto small"></i>
        </a>
        <div id="collapseUtilitiesUmum" class="collapse {{ $isPengaturanUmumMenu ? 'show' : '' }}"
            aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @isroute('jurusan.index')" href="{{ route('jurusan.index') }}">Jurusan</a>
                <a class="collapse-item @isroute('program_studi.index')"
                    href="{{ route('program_studi.index') }}">Program Studi</a>
                <a class="collapse-item @isroute('pegawai.index')" href="{{ route('pegawai.index') }}">Pegawai</a>


            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ $isPengaturanLppmMenu ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilitiesLPPM"
            aria-expanded="{{ $isPengaturanLppmMenu ? 'true' : 'false' }}" aria-controls="collapseUtilitiesLPPM">
            <i class="fas fa-fw fa-pencil-ruler"></i>
            <span>Kelola Form</span>
            <i class="fas fa-angle-down ms-auto small"></i>
        </a>
        <div id="collapseUtilitiesLPPM" class="collapse {{ $isPengaturanLppmMenu ? 'show' : '' }}"
            aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <a class="collapse-item" href="{{ route('luaran.index') }}">Hibah</a> -->
                <a class="collapse-item @isroute('skema.index')" href="{{ route('skema.index') }}">Skema</a>
                <a class="collapse-item @isroute('luaran.index')" href="{{ route('luaran.index') }}">Luaran</a>
                <a class="collapse-item @isroute('bidang-penelitian.index')"
                    href="{{ route('bidang-penelitian.index') }}">Bidang Penelitian</a>
                <a class="collapse-item @isroute('rab.index')" href="{{ route('rab.index') }}">RAB</a>
                <a class="collapse-item @isroute('form-penilaian-review.index')"
                    href="{{ route('form-penilaian-review.index') }}">Form Review</a>
                <a class="collapse-item @isroute('form-penilaian-laporan-kemajuan.index')"
                    href="{{ route('form-penilaian-laporan-kemajuan.index') }}">Laporan Kemajuan</a>
                <a class="collapse-item @isroute('form-penilaian-laporan-akhir.index')"
                    href="{{ route('form-penilaian-laporan-akhir.index') }}">Laporan Akhir</a>

            </div>
        </div>
    </li>

    <!-- Kelola User moved outside of Pengaturan -->
    <li class="nav-item {{ $isKelolaUser ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Kelola User</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Penelitian dan Pengabdian
    </div>

    <li class="nav-item {{ $isTimeline ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.timeline.index') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Timeline</span>
        </a>
    </li>

    {{-- <li class="nav-item @isroute('fokus-bidang.index')">
        <a class="nav-link" href="{{ route('fokus-bidang.index') }}">
            <i class="fas fa-fw fa-bullseye"></i>
            <span>Bidang Fokus</span>
        </a>
    </li> --}}

    @php
        $penelitianMenuActive = request()->routeIs('penelitian-adm.*');
        $pengabdianMenuActive = request()->routeIs('pengabdian-adm.*');
    @endphp

    <li class="nav-item {{ $penelitianMenuActive ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePenelitianAdmin"
            aria-expanded="{{ $penelitianMenuActive ? 'true' : 'false' }}" aria-controls="collapsePenelitianAdmin">
            <i class="fas fa-fw fa-flask"></i>
            <span>Penelitian</span>
            <i class="fas fa-angle-down ms-auto small"></i>
        </a>
        <div id="collapsePenelitianAdmin" class="collapse {{ $penelitianMenuActive ? 'show' : '' }}"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @isroute('penelitian-adm.index')"
                    href="{{ route('penelitian-adm.index') }}">Daftar Proposal</a>
                <a class="collapse-item @isroute('penelitian-adm.revisi.index')"
                    href="{{ route('penelitian-adm.revisi.index') }}">Revisi Proposal</a>
                <a class="collapse-item @if(request('jenis') == 'penelitian' && request()->routeIs('admin.laporan-kemajuan.index')) active @endif"
                    href="{{ route('admin.laporan-kemajuan.index', ['jenis' => 'penelitian']) }}">
                    Laporan Kemajuan</a>
                <a class="collapse-item @if(request('jenis') == 'penelitian' && request()->routeIs('admin.laporan-akhir.index')) active @endif"
                    href="{{ route('admin.laporan-akhir.index', ['jenis' => 'penelitian']) }}">Laporan Akhir</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ $pengabdianMenuActive ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePengabdianAdmin"
            aria-expanded="{{ $pengabdianMenuActive ? 'true' : 'false' }}" aria-controls="collapsePengabdianAdmin">
            <i class="fas fa-fw fa-hands-helping"></i>
            <span>Pengabdian</span>
            <i class="fas fa-angle-down ms-auto small"></i>
        </a>
        <div id="collapsePengabdianAdmin" class="collapse {{ $pengabdianMenuActive ? 'show' : '' }}"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @isroute('pengabdian-adm.index')"
                    href="{{ route('pengabdian-adm.index') }}">Daftar Proposal</a>
                <a class="collapse-item @isroute('pengabdian-adm.revisi.index')"
                    href="{{ route('pengabdian-adm.revisi.index') }}">Revisi Proposal</a>
                <a class="collapse-item @if(request('jenis') == 'pengabdian' && request()->routeIs('admin.laporan-kemajuan.index')) active @endif"
                    href="{{ route('admin.laporan-kemajuan.index', ['jenis' => 'pengabdian']) }}">
                    Laporan Kemajuan
                </a>
                <a class="collapse-item @if(request('jenis') == 'pengabdian' && request()->routeIs('admin.laporan-akhir.index')) active @endif"
                    href="{{ route('admin.laporan-akhir.index', ['jenis' => 'pengabdian']) }}">Laporan Akhir</a>
            </div>
        </div>
    </li>




    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Pengabdian Masyarakat
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDokumenLPMU"
            aria-expanded="true" aria-controls="collapseDokumenLPMU">
            <i class="fas fa-fw fa-cog"></i>
            <span>Dokumen</span>
        </a>
        <div id="collapseDokumenLPMU" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Dokumen:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAkreditasi"
            aria-expanded="true" aria-controls="collapseAkreditasi">
            <i class="fas fa-fw fa-cog"></i>
            <span>Akreditasi</span>
        </a>
        <div id="collapseAkreditasi" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Akreditasi:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!--  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAgendaLPMU"
            aria-expanded="true" aria-controls="collapseAgendaLPMU">
            <i class="fas fa-fw fa-cog"></i>
            <span>Agenda</span>
        </a>
        <div id="collapseAgendaLPMU" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Agenda:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Utilities Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilitiesLPMU"
            aria-expanded="true" aria-controls="collapseUtilitiesLPMU">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilitiesLPMU" class="collapse" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Dokumen</a>
                <a class="collapse-item" href="utilities-border.html">Akreditasi</a>
                <a class="collapse-item" href="utilities-animation.html">Agenda</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        LPMU
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Charts -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li> -->

    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    {{-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> --}}

    <!-- Current User Info as Profile Link -->
    <li class="nav-item mt-auto mb-2">
        <a class="d-flex align-items-center mb-2 text-decoration-none sidebar-user-link"
            href="{{ route('account.profile') }}">
            @php
                $user = Auth::user();
                $avatarUrl = $user && $user->avatar_path ? Storage::url($user->avatar_path) : url('img/undraw_profile.svg');
            @endphp
            <img src="{{ $avatarUrl }}" class="rounded-circle me-2 sidebar-avatar">
            <div class="text-white sidebar-user-text">
                <div class="fw-bold">{{ $user->name ?? 'User' }}</div>
                <div class="small text-white-50 text-capitalize">{{ $user->role ?? 'Role' }}</div>
            </div>
        </a>
    </li>
    <li class="nav-item mt-2 mb-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="btn btn-light w-100" href="{{ route('logout') }}"
                onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt me-1"></i>
                <span>Logout</span>
            </a>
        </form>
    </li>

    <!-- Sidebar Message -->
    <!--     <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>LPPM-LPMU ITH</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> -->

</ul>
<!-- End of Sidebar -->

<button class="sidebar-collapse-toggle" id="sidebarCollapseToggle" type="button" aria-label="Sembunyikan sidebar">
    <i class="fas fa-chevron-left"></i>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('accordionSidebar');
        const desktopToggle = document.getElementById('sidebarToggle');
        const topToggle = document.getElementById('sidebarToggleTop');
        const collapseToggle = document.getElementById('sidebarCollapseToggle');
        const body = document.body;
        const breakpoint = 1024;
        const hiddenClass = 'sidebar-hidden';
        const hiddenStorageKey = 'sidebarHiddenStateAdmin';

        const resetLegacyToggle = () => {
            body.classList.remove('sidebar-toggled');
            sidebar && sidebar.classList.remove('toggled');
        };

        const getHiddenPreference = () => {
            try {
                return window.localStorage.getItem(hiddenStorageKey);
            } catch (error) {
                return null;
            }
        };

        const setHiddenPreference = (value) => {
            try {
                window.localStorage.setItem(hiddenStorageKey, value);
            } catch (error) {
                /* noop */
            }
        };

        const updateCollapseIcon = () => {
            if (!collapseToggle) return;
            const icon = collapseToggle.querySelector('i');
            if (!icon) return;
            const isHidden = body.classList.contains(hiddenClass);
            icon.classList.toggle('fa-chevron-left', !isHidden);
            icon.classList.toggle('fa-chevron-right', isHidden);
        };

        const applyHiddenPreference = () => {
            const stored = getHiddenPreference();
            const shouldHide = stored === '1' || (stored === null && window.innerWidth < breakpoint);
            body.classList.toggle(hiddenClass, shouldHide);
            updateCollapseIcon();
        };

        const toggleSidebarVisibility = () => {
            resetLegacyToggle();
            const shouldHide = !body.classList.contains(hiddenClass);
            if (shouldHide) {
                body.classList.add(hiddenClass);
            } else {
                body.classList.remove(hiddenClass);
            }
            setHiddenPreference(shouldHide ? '1' : '0');
            updateCollapseIcon();
        };

        applyHiddenPreference();
        window.addEventListener('resize', function () {
            if (getHiddenPreference() === null) {
                applyHiddenPreference();
            } else {
                updateCollapseIcon();
            }
        });

        const wireToggleButton = (btn) => {
            if (!btn) return;
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                toggleSidebarVisibility();
            });
        };

        wireToggleButton(desktopToggle);
        wireToggleButton(topToggle);

        if (collapseToggle) {
            collapseToggle.addEventListener('click', function (event) {
                event.preventDefault();
                toggleSidebarVisibility();
            });
        }

        const autoHideAfterNavigate = (element) => {
            if (!element) return;
            element.addEventListener('click', function () {
                if (window.innerWidth >= breakpoint) return;
                if (body.classList.contains(hiddenClass)) return;
                toggleSidebarVisibility();
            });
        };

        const navLinks = sidebar ? sidebar.querySelectorAll('.nav-link:not([data-bs-toggle="collapse"]), .collapse-item:not(.disabled-link)') : [];
        navLinks.forEach(autoHideAfterNavigate);

        body.classList.add('sidebar-ready');
    });
</script>