<!-- Sidebar -->
<style>
    :root { --sb-bg:#21163d; --sb-bg2:#352467; --sb-accent:#7c3aed; --sb-accent-2:#8b5cf6; --sb-text:#e5e7eb; --sb-text-dim:#9ca3af; --sb-active:#7c3aed; }
    .sidebar.sidebar-modern { background: linear-gradient(180deg, var(--sb-bg) 0%, var(--sb-bg2) 100%); color: var(--sb-text); padding: 0.7rem 0.85rem 0.5rem; width: 280px; box-shadow: inset 0 0 0 1px rgba(124,58,237,0.15), 0 8px 30px rgba(2,6,23,.35); border-right: 1px solid rgba(124,58,237,0.18); position: fixed; top: 0; left: 0; bottom: 0; height: 100vh; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none; box-sizing: border-box; z-index: 1035; transition: transform .28s ease, box-shadow .28s ease; }
    .sidebar.sidebar-modern::-webkit-scrollbar { width: 0; height: 0; }
    .sidebar.sidebar-modern .sidebar-brand { padding: .85rem .75rem; margin: .25rem .25rem 0.75rem; border-radius: 14px; background: radial-gradient(120% 120% at 0% 0%, rgba(124,58,237,.22) 0%, rgba(139,92,246,.18) 42%, rgba(255,255,255,0.04) 100%); color: var(--sb-text); box-shadow: 0 4px 16px rgba(2,6,23,.25) inset, 0 6px 22px rgba(2,6,23,.35); position: relative; }
    .sidebar.sidebar-modern .sidebar-brand-icon { flex-shrink: 0; }
    .sidebar.sidebar-modern .sidebar-brand-text { font-weight: 700; letter-spacing: .4px; white-space: nowrap; position: absolute; left: 50%; transform: translateX(-50%); color: var(--sb-text); line-height: 1.2; z-index: 1; }
    .sidebar.sidebar-modern .sidebar-brand small { color: var(--sb-text-dim); font-weight: 500; }
    .sidebar.sidebar-modern .sidebar-divider { border-color: rgba(255,255,255,0.06); margin: .65rem .5rem; }
    .sidebar.sidebar-modern .sidebar-heading { font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; color: var(--sb-text-dim); padding: .25rem .75rem; }
    .sidebar.sidebar-modern .nav-item { margin: .15rem .25rem; width: calc(100% - .5rem); }
    .sidebar.sidebar-modern .nav-link { width: 100%; box-sizing: border-box; position: relative; display: flex; align-items: center; gap: .65rem; padding: .7rem .95rem; border-radius: 12px; color: var(--sb-text); background: rgba(255,255,255,0.02); transition: all .18s ease; border: 1px solid transparent; }
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
    .sidebar-mobile-toggle { position: fixed; right: 1rem; top: 1rem; width: 48px; height: 48px; border-radius: 999px; border: none; background: rgba(124,58,237,0.95); color: white; display: none; align-items: center; justify-content: center; z-index: 1036; box-shadow: 0 12px 32px rgba(15,23,42,0.35); }
    .sidebar-mobile-toggle:focus-visible { outline: 2px solid rgba(255,255,255,0.7); outline-offset: 2px; }
    .sidebar-backdrop { position: fixed; inset: 0; background: rgba(15,23,42,0.55); z-index: 1030; opacity: 0; pointer-events: none; transition: opacity .25s ease; }
    .sidebar-backdrop.active { opacity: 1; pointer-events: auto; }
    body.sidebar-mobile-open { overflow: hidden; }
    @media (max-width: 991.98px) {
        .sidebar.sidebar-modern { width: min(85vw, 320px); transform: translateX(-105%); box-shadow: 0 25px 60px rgba(2,6,23,.45); }
        .sidebar.sidebar-modern.is-open { transform: translateX(0); }
        .sidebar-mobile-toggle { display: inline-flex; }
        .sidebar.sidebar-modern .sidebar-brand { flex-direction: row; align-items: center; }
        .sidebar.sidebar-modern .sidebar-brand-icon { margin-bottom: 0; margin-right: 0.5rem !important; }
        .sidebar.sidebar-modern .sidebar-brand-text { position: absolute !important; transform: translateX(-50%) !important; left: 50% !important; text-align: center; width: auto; margin-top: 0; display: block !important; }
    }
</style>
<ul class="navbar-nav sidebar sidebar-dark accordion d-flex flex-column sidebar-modern" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="{{ route('reviewer.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ url('Logo.png') }}" height="36">
        </div>
        <div class="sidebar-brand-text">LPPM-PM</div>
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
            <i class="fas fa-fw fa-flask"></i>
            <span>Penelitian</span>
        </a>
    </li>

    <!-- Nav Item - Pengabdian -->
    <li class="nav-item @isroute('pengabdian-rev.index')">
        <a class="nav-link" href="{{ route('pengabdian-rev.index') }}">
            <i class="fas fa-fw fa-hands-helping"></i>
            <span>Pengabdian</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    {{-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> --}}

    <!-- Sidebar Message -->
<!--     <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>LPPM-LPMU ITH</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> -->

    <!-- Current User Info as Profile Link -->
    <li class="nav-item mt-auto">
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
<!-- End of Sidebar -->

<button class="sidebar-mobile-toggle" id="sidebarMobileToggle" type="button" aria-label="Tampilkan sidebar" aria-expanded="false">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('accordionSidebar');
    const mobileToggle = document.getElementById('sidebarMobileToggle');
    const backdrop = document.getElementById('sidebarBackdrop');
    const desktopToggle = document.getElementById('sidebarToggle');
    const topbar = document.querySelector('.topbar');
    const body = document.body;
    const breakpoint = 992;

    const updateMobileIcon = (isOpen) => {
        if (!mobileToggle) return;
        const icon = mobileToggle.querySelector('i');
        if (!icon) return;
        icon.classList.toggle('fa-bars', !isOpen);
        icon.classList.toggle('fa-times', isOpen);
    };

    const resetLegacyToggle = () => {
        body.classList.remove('sidebar-toggled');
        sidebar && sidebar.classList.remove('toggled');
    };

    const openSidebar = () => {
        resetLegacyToggle();
        sidebar && sidebar.classList.add('is-open');
        backdrop && backdrop.classList.add('active');
        body.classList.add('sidebar-mobile-open');
        mobileToggle && mobileToggle.setAttribute('aria-expanded', 'true');
        updateMobileIcon(true);
    };

    const closeSidebar = () => {
        resetLegacyToggle();
        sidebar && sidebar.classList.remove('is-open');
        backdrop && backdrop.classList.remove('active');
        body.classList.remove('sidebar-mobile-open');
        mobileToggle && mobileToggle.setAttribute('aria-expanded', 'false');
        updateMobileIcon(false);
    };

    const setToggleOffset = () => {
        if (!mobileToggle) return;
        const offset = (topbar ? topbar.offsetHeight + 12 : 16);
        mobileToggle.style.top = offset + 'px';
    };

    const handleResize = () => {
        if (window.innerWidth >= breakpoint) {
            closeSidebar();
        }
        setToggleOffset();
    };

    handleResize();
    setToggleOffset();
    window.addEventListener('resize', handleResize);

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function () {
            if (sidebar && sidebar.classList.contains('is-open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    backdrop && backdrop.addEventListener('click', closeSidebar);

    const attachHijack = (btn, toggleBehavior = false) => {
        if (!btn) return;
        btn.addEventListener('click', function (event) {
            if (window.innerWidth < breakpoint) {
                event.preventDefault();
                event.stopImmediatePropagation();
                if (toggleBehavior && sidebar && sidebar.classList.contains('is-open')) {
                    closeSidebar();
                } else if (toggleBehavior) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            }
        }, true);
    };

    attachHijack(desktopToggle);
});
</script>