<!-- Sidebar -->
<style>
    :root { --sb-bg:#1a1029; --sb-bg2:#2a1748; --sb-accent:#7c3aed; --sb-accent-2:#8b5cf6; --sb-text:#e5e7eb; --sb-text-dim:#9ca3af; --sb-active:#7c3aed; }
    .sidebar.sidebar-modern { background: linear-gradient(180deg, var(--sb-bg) 0%, var(--sb-bg2) 100%); color: var(--sb-text); padding: 0.7rem 0.85rem 0.5rem; width: 280px; box-shadow: inset 0 0 0 1px rgba(124,58,237,0.15), 0 8px 30px rgba(2,6,23,.35); border-right: 1px solid rgba(124,58,237,0.18); }
    .sidebar.sidebar-modern .sidebar-brand { padding: .85rem .75rem; margin: .25rem .25rem 0.75rem; border-radius: 14px; background: radial-gradient(120% 120% at 0% 0%, rgba(99,102,241,.18) 0%, rgba(167,139,250,.14) 42%, rgba(255,255,255,0.04) 100%); color: var(--sb-text); }
    .sidebar.sidebar-modern .sidebar-brand-text { font-weight: 700; letter-spacing: .4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; }
    .sidebar.sidebar-modern .sidebar-divider { border-color: rgba(255,255,255,0.06); margin: .65rem .5rem; }
    .sidebar.sidebar-modern .nav-item { margin: .15rem .25rem; }
    .sidebar.sidebar-modern .nav-link { display: flex; align-items: center; gap: .65rem; padding: .7rem .85rem; border-radius: 12px; color: var(--sb-text); background: rgba(255,255,255,0.02); transition: all .18s ease; border: 1px solid transparent; }
    .sidebar.sidebar-modern .nav-link i { width: 1.25rem; text-align: center; color: var(--sb-text-dim); }
    .sidebar.sidebar-modern .nav-link span { flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sidebar.sidebar-modern .nav-link:hover { background: rgba(124,58,237,0.10); border-color: rgba(124,58,237,0.28); }
    .sidebar.sidebar-modern .nav-item.active > .nav-link, .sidebar.sidebar-modern .nav-link.active { background: linear-gradient(90deg, rgba(124,58,237,.28) 0%, rgba(139,92,246,.25) 100%); border-color: rgba(139,92,246,.42); }
    .sidebar-user-link { background: rgba(255,255,255,0.03); padding: .7rem .85rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); }
    .sidebar-avatar { width: 42px; height: 42px; object-fit: cover; border: 2px solid rgba(255,255,255,0.15); }
    .sidebar .btn.btn-light.w-100 { background: linear-gradient(90deg, rgba(124,58,237,.18) 0%, rgba(99,102,241,.18) 100%); color: var(--sb-text); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; }
</style>
<ul class="navbar-nav sidebar sidebar-dark accordion d-flex flex-column sidebar-modern" id="accordionSidebar" style="position:fixed;top:0;left:0;bottom:0;height:100vh;overflow-y:auto;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-start" href="{{ route('dosen.dashboard') }}">
        <div class="sidebar-brand-icon me-2">
            <img src="{{ url('Logo.png') }}" height="36">
        </div>
        <div class="sidebar-brand-text mx-1">LPPM-PM</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @isroute('dosen.dashboard')">
        <a class="nav-link" href="{{ route('dosen.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Penelitian -->
    <li class="nav-item @isroute('penelitian-dos.index')">
        <a class="nav-link" href="{{ route('penelitian-dos.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Penelitian</span>
        </a>
    </li>

    <!-- Nav Item - Pengabdian -->
    <li class="nav-item @isroute('pengabdian-dos.index')">
        <a class="nav-link" href="{{ route('pengabdian-dos.index') }}">
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

    <!-- Current User Info as Profile Link -->
    <li class="nav-item mt-auto mb-2.5">
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

</ul>
<!-- End of Sidebar