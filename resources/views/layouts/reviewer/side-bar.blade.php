<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('reviewer.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ url('Logo.png') }}" height="40">
        </div>
        <div class="sidebar-brand-text mx-3">LPPM-PM</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @isroute('reviewer.dashboard')">
        <a class="nav-link" href="{{ route('reviewer.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Penelitian -->
    <li class="nav-item @isroute('penelitian-rev.index')">
        <a class="nav-link" href="{{ route('penelitian-rev.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Penelitian</span>
        </a>
    </li>

    <!-- Nav Item - Pengabdian -->
    <li class="nav-item @isroute('pengabdian-rev.index')">
        <a class="nav-link" href="{{ route('pengabdian-rev.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Pengabdian</span>
        </a>
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

</ul>
<!-- End of Sidebar