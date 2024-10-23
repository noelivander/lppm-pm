<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ url('Logo.png') }}" height="40">
        </div>
        <div class="sidebar-brand-text mx-3">LPPM-PM <!-- <sup>Admin</sup> --></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
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
                <h6 class="collapse-header">Custom Kelembagaan:</h6>
                <a class="collapse-item" href="{{ route('tentang-satker.index') }}">Tentang</a>
                <a class="collapse-item" href="{{ route('visi-misi.index') }}">Visi Misi</a>
                <a class="collapse-item" href="{{ route('struktur-organisasi.index') }}">Struktur Organisasi</a>
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
                <h6 class="collapse-header">Layanan:</h6>
                <a class="collapse-item" href="{{ route('agenda.index') }}">Agenda</a>
                <a class="collapse-item" href="{{ route('berita.index') }}">Berita</a>
                <a class="collapse-item" href="{{ route('dokumen_penting.index') }}">Dokumen</a>
                <a class="collapse-item" href="{{ route('pengumuman.index') }}">Pengumuman</a>
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
                <h6 class="collapse-header">Custom Pengaturan:</h6>
                <a class="collapse-item" href="{{ route('jurusan.index') }}">Jurusan</a>
                <a class="collapse-item" href="{{ route('program_studi.index') }}">Program Studi</a>
                <a class="collapse-item" href="{{ route('pegawai.index') }}">Pegawai</a>
                <a class="collapse-item" href="{{ route('related_link.index') }}">Tautan</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Penelitian dan Pengabdian
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('fokus-bidang.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Bidang Fokus</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('penelitian-adm.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Penelitian</span>
        </a>
    </li>

    <li class="nav-item">
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
                <a class="collapse-item" href="{{ route('skema.index') }}">Skema</a>
                <a class="collapse-item" href="{{ route('luaran.index') }}">Luaran</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

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

    <!-- Sidebar Message -->
<!--     <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>LPPM-LPMU ITH</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> -->

</ul>
<!-- End of Sidebar