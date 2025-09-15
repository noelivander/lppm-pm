<!-- Sidebar -->
<style>
    :root { --sb-bg:#1a1029; --sb-bg2:#2a1748; --sb-accent:#7c3aed; --sb-accent-2:#8b5cf6; --sb-text:#e5e7eb; --sb-text-dim:#9ca3af; --sb-active:#7c3aed; }
    .sidebar.sidebar-modern { background: linear-gradient(180deg, var(--sb-bg) 0%, var(--sb-bg2) 100%); color: var(--sb-text); padding: 0.7rem 0.85rem 0.5rem; width: 280px; box-shadow: inset 0 0 0 1px rgba(124,58,237,0.15), 0 8px 30px rgba(2,6,23,.35); border-right: 1px solid rgba(124,58,237,0.18); position: fixed; top: 0; left: 0; bottom: 0; height: 100vh; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none; box-sizing: border-box; }
    .sidebar.sidebar-modern::-webkit-scrollbar { width: 0; height: 0; }
    .sidebar.sidebar-modern .sidebar-brand { padding: .85rem .75rem; margin: .25rem .25rem 0.75rem; border-radius: 14px; background: radial-gradient(120% 120% at 0% 0%, rgba(124,58,237,.22) 0%, rgba(139,92,246,.18) 42%, rgba(255,255,255,0.04) 100%); color: var(--sb-text); box-shadow: 0 4px 16px rgba(2,6,23,.25) inset, 0 6px 22px rgba(2,6,23,.35); }
    .sidebar.sidebar-modern .sidebar-brand-text { font-weight: 700; letter-spacing: .4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; }
    .sidebar.sidebar-modern .sidebar-brand small { color: var(--sb-text-dim); font-weight: 500; }
    .sidebar.sidebar-modern .sidebar-divider { border-color: rgba(255,255,255,0.06); margin: .65rem .5rem; }
    .sidebar.sidebar-modern .sidebar-heading { font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; color: var(--sb-text-dim); padding: .25rem .75rem; }
    .sidebar.sidebar-modern .nav-item { margin: .15rem .25rem; }
    .sidebar.sidebar-modern .nav-link { position: relative; display: flex; align-items: center; gap: .65rem; padding: .7rem .85rem; border-radius: 12px; color: var(--sb-text); background: rgba(255,255,255,0.02); transition: all .18s ease; border: 1px solid transparent; }
    .sidebar.sidebar-modern .nav-link i { width: 1.25rem; text-align: center; color: var(--sb-text-dim); }
    .sidebar.sidebar-modern .nav-link span { flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sidebar.sidebar-modern .nav-link:hover { background: rgba(124,58,237,0.10); border-color: rgba(124,58,237,0.28); box-shadow: 0 8px 20px rgba(124,58,237,.22); transform: translateY(-1px); }
    .sidebar.sidebar-modern .nav-item.active > .nav-link, .sidebar.sidebar-modern .nav-link.active { background: linear-gradient(90deg, rgba(124,58,237,.28) 0%, rgba(139,92,246,.25) 100%); border-color: rgba(139,92,246,.42); box-shadow: 0 10px 26px rgba(124,58,237,.25); }
    .sidebar.sidebar-modern .collapse-inner { background: rgba(255, 255, 255, 1) !important; border-radius: 12px; margin: .25rem .5rem .5rem; padding: .5rem; border: 1px dashed rgba(255,255,255,0.07); }
    .sidebar.sidebar-modern .collapse-item { border-radius: 10px; padding: .5rem .65rem; color: var(--sb-text); }
    .sidebar.sidebar-modern .collapse-item:hover, .sidebar.sidebar-modern .collapse-item.active { background: rgba(255,255,255,0.06); }
    .sidebar-user-link { background: rgba(255,255,255,0.03); padding: .7rem .85rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); transition: all .18s ease; }
    .sidebar-user-link:hover { background: rgba(255,255,255,0.06); transform: translateY(-1px); }
    .sidebar-avatar { width: 42px; height: 42px; object-fit: cover; box-shadow: 0 6px 18px rgba(2,6,23,.35); border: 2px solid rgba(255,255,255,0.15); }
    .sidebar-user-text .fw-bold { font-size: .95rem; }
    .sidebar .btn.btn-light.w-100 { background: linear-gradient(90deg, rgba(124,58,237,.18) 0%, rgba(139,92,246,.18) 100%); color: var(--sb-text); border: 1px solid rgba(139,92,246,0.25); border-radius: 12px; }
    .sidebar .btn.btn-light.w-100:hover { background: linear-gradient(90deg, rgba(124,58,237,.28) 0%, rgba(139,92,246,.28) 100%); color: #fff; border-color: rgba(139,92,246,0.38); box-shadow: 0 10px 30px rgba(124,58,237,.28); }
    #sidebarToggle { width: 34px; height: 34px; background: rgba(255,255,255,0.06); color: var(--sb-text); }
    #sidebarToggle:hover { background: rgba(255,255,255,0.12); }
</style>
<ul class="navbar-nav sidebar sidebar-dark accordion d-flex flex-column sidebar-modern" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-start" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon me-2">
            <img src="{{ url('Logo.png') }}" height="36">
        </div>
        <div class="sidebar-brand-text mx-1">
            LPPM-PM
            <div><small>Administration</small></div>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @isroute('admin.dashboard')">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKelembagaan"
            aria-expanded="true" aria-controls="collapseKelembagaan">
            <i class="fas fa-fw fa-university"></i>
            <span>Kelembagaan</span>
        </a>
        <div id="collapseKelembagaan" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @isroute('tentang-satker.index')" href="{{ route('tentang-satker.index') }}">Tentang</a>
                <a class="collapse-item @isroute('visi-misi.index')" href="{{ route('visi-misi.index') }}">Visi Misi</a>
                <a class="collapse-item @isroute('struktur-organisasi.index')" href="{{ route('struktur-organisasi.index') }}">Struktur Organisasi</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayanan"
            aria-expanded="true" aria-controls="collapseLayanan">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Layanan</span>
        </a>
        <div id="collapseLayanan" class="collapse" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @isroute('agenda.index')" href="{{ route('agenda.index') }}">Agenda</a>
                <a class="collapse-item @isroute('berita.index')" href="{{ route('berita.index') }}">Berita</a>
                <a class="collapse-item @isroute('dokumen_penting.index')" href="{{ route('dokumen_penting.index') }}">Dokumen</a>
                <a class="collapse-item @isroute('pengumuman.index')" href="{{ route('pengumuman.index') }}">Pengumuman</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pengaturan Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilitiesUmum"
            aria-expanded="true" aria-controls="collapseUtilitiesUmum">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pengaturan</span>
        </a>
        <div id="collapseUtilitiesUmum" class="collapse" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @isroute('jurusan.index')" href="{{ route('jurusan.index') }}">Jurusan</a>
                <a class="collapse-item @isroute('program_studi.index')" href="{{ route('program_studi.index') }}">Program Studi</a>
                <a class="collapse-item @isroute('pegawai.index')" href="{{ route('pegawai.index') }}">Pegawai</a>
                <a class="collapse-item @isroute('related_link.index')" href="{{ route('related_link.index') }}">Tautan</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Penelitian dan Pengabdian
    </div>

    <li class="nav-item @isroute('admin.timeline.index')">
        <a class="nav-link" href="{{ route('admin.timeline.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Timeline</span>
        </a>
    </li>

    <li class="nav-item @isroute('fokus-bidang.index')">
        <a class="nav-link" href="{{ route('fokus-bidang.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Bidang Fokus</span>
        </a>
    </li>

    <li class="nav-item @isroute('penelitian-adm.index')">
        <a class="nav-link" href="{{ route('penelitian-adm.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Penelitian</span>
        </a>
    </li>

    <li class="nav-item @isroute('pengabdian-adm.index')">
        <a class="nav-link" href="{{ route('pengabdian-adm.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Pengabdian</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilitiesLPPM"
            aria-expanded="true" aria-controls="collapseUtilitiesLPPM">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pengaturan</span>
        </a>
        <div id="collapseUtilitiesLPPM" class="collapse" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pengaturan:</h6>
                <!-- <a class="collapse-item" href="{{ route('luaran.index') }}">Hibah</a> -->
                <a class="collapse-item @isroute('skema.index')" href="{{ route('skema.index') }}">Skema</a>
                <a class="collapse-item @isroute('luaran.index')" href="{{ route('luaran.index') }}">Luaran</a>
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
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Current User Info as Profile Link -->
    <li class="nav-item mt-auto mb-2">
        <a class="d-flex align-items-center mb-2 text-decoration-none sidebar-user-link" href="{{ route('account.profile') }}">
            <img src="{{ Auth::user()->avatar_path ? Storage::url(Auth::user()->avatar_path) : url('img/undraw_profile.svg') }}" class="rounded-circle me-2 sidebar-avatar">
            <div class="text-white sidebar-user-text">
                <div class="fw-bold">{{ Auth::user()->name }}</div>
                <div class="small text-white-50 text-capitalize">{{ Auth::user()->role }}</div>
            </div>
        </a>
    </li>
    <li class="nav-item mt-2 mb-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="btn btn-light w-100" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
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
<!-- End of Sidebar