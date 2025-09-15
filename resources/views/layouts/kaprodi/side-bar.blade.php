<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-flex flex-column" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('kaprodi.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ url('Logo.png') }}" height="40">
        </div>
        <div class="sidebar-brand-text mx-3">LPPM-PM</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @isroute('kaprodi.dashboard')">
        <a class="nav-link" href="{{ route('kaprodi.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAmi"
            aria-expanded="true" aria-controls="collapseAmi">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>AMI</span>
        </a>
        <div id="collapseAmi" class="collapse" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Prodi:</h6>
                <a class="collapse-item" href="{{ route('si.index') }}">Sistem Informasi</a>
                <a class="collapse-item" href="{{ route('ik.index') }}">Ilmu Komputer</a>
                <a class="collapse-item" href="{{ route('mtk.index') }}">Matematika</a>
            </div>
        </div>
    </li>

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

    <!-- Current User Info as Profile Link -->
    <li class="nav-item mt-auto px-3 mb-2">
        <a class="d-flex align-items-center mb-2 text-decoration-none sidebar-user-link" href="{{ route('account.profile') }}">
            <img src="{{ Auth::user()->avatar_path ? Storage::url(Auth::user()->avatar_path) : url('img/undraw_profile.svg') }}" class="rounded-circle me-2 sidebar-avatar">
            <div class="text-white sidebar-user-text">
                <div class="fw-bold">{{ Auth::user()->name }}</div>
                <div class="small text-white-50 text-capitalize">{{ Auth::user()->role }}</div>
            </div>
        </a>
    </li>
    <li class="nav-item px-3 mt-2 mb-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="btn btn-light w-100" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt me-1"></i>
                <span>Logout</span>
            </a>
        </form>
    </li>

</ul>
<!-- End of Sidebar