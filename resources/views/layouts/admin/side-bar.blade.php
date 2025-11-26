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
        width: 280px;
        box-shadow: inset 0 0 0 1px rgba(124, 58, 237, 0.15), 0 8px 30px rgba(2, 6, 23, .35);
        border-right: 1px solid rgba(124, 58, 237, 0.18);
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
        transition: transform .28s ease, box-shadow .28s ease;
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
    }

    .sidebar.sidebar-modern .sidebar-brand-text {
        font-weight: 700;
        letter-spacing: .4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
        display: block;
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

    .sidebar-mobile-toggle {
        position: fixed;
        right: 1rem;
        top: 1rem;
        width: 48px;
        height: 48px;
        border-radius: 999px;
        border: none;
        background: rgba(124, 58, 237, 0.95);
        color: white;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1036;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.35);
    }

    .sidebar-mobile-toggle:focus-visible {
        outline: 2px solid rgba(255, 255, 255, 0.7);
        outline-offset: 2px;
    }

    .sidebar-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        z-index: 1030;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s ease;
    }

    .sidebar-backdrop.active {
        opacity: 1;
        pointer-events: auto;
    }

    body.sidebar-mobile-open {
        overflow: hidden;
    }

    @media (max-width: 991.98px) {
        .sidebar.sidebar-modern {
            width: min(85vw, 320px);
            transform: translateX(-105%);
            box-shadow: 0 25px 60px rgba(2, 6, 23, .45);
        }

        .sidebar.sidebar-modern.is-open {
            transform: translateX(0);
        }

        .sidebar-mobile-toggle {
            display: inline-flex;
        }
    }
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
                <a class="collapse-item @isroute('tentang-satker.index')"
                    href="{{ route('tentang-satker.index') }}">Tentang</a>
                <a class="collapse-item @isroute('visi-misi.index')" href="{{ route('visi-misi.index') }}">Visi Misi</a>
                <a class="collapse-item @isroute('struktur-organisasi.index')"
                    href="{{ route('struktur-organisasi.index') }}">Struktur Organisasi</a>
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
                <a class="collapse-item @isroute('dokumen_penting.index')"
                    href="{{ route('dokumen_penting.index') }}">Dokumen</a>
                <a class="collapse-item @isroute('pengumuman.index')"
                    href="{{ route('pengumuman.index') }}">Pengumuman</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pengaturan Collapse Menu (General) -->
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
                <a class="collapse-item @isroute('program_studi.index')"
                    href="{{ route('program_studi.index') }}">Program Studi</a>
                <a class="collapse-item @isroute('pegawai.index')" href="{{ route('pegawai.index') }}">Pegawai</a>
                <a class="collapse-item @isroute('related_link.index')"
                    href="{{ route('related_link.index') }}">Tautan</a>
                <a class="collapse-item @isroute('admin.landing-page.index')"
                    href="{{ route('admin.landing-page.index') }}">Landing Page</a>
            </div>
        </div>
    </li>

    <!-- Kelola User -->
    <li class="nav-item @isroute('users.index')">
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

    <li class="nav-item @isroute('admin.timeline.index')">
        <a class="nav-link" href="{{ route('admin.timeline.index') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Timeline</span>
        </a>
    </li>

    <li class="nav-item @isroute('fokus-bidang.index')">
        <a class="nav-link" href="{{ route('fokus-bidang.index') }}">
            <i class="fas fa-fw fa-bullseye"></i>
            <span>Bidang Fokus</span>
        </a>
    </li>

    <li class="nav-item @isroute('penelitian-adm.index')">
        <a class="nav-link" href="{{ route('penelitian-adm.index') }}">
            <i class="fas fa-fw fa-flask"></i>
            <span>Penelitian</span>
        </a>
    </li>

    <li class="nav-item @isroute('pengabdian-adm.index')">
        <a class="nav-link" href="{{ route('pengabdian-adm.index') }}">
            <i class="fas fa-fw fa-hands-helping"></i>
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
                <!-- <a class="collapse-item" href="{{ route('luaran.index') }}">Hibah</a> -->
                <a class="collapse-item @isroute('skema.index')" href="{{ route('skema.index') }}">Skema</a>
                <a class="collapse-item @isroute('luaran.index')" href="{{ route('luaran.index') }}">Luaran</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <i class="fas fa-sign-out-alt me-1"></i>
        <span>Logout</span>
    </div>

</ul>
<!-- End of Sidebar -->

<button class="sidebar-mobile-toggle" id="sidebarMobileToggle" type="button" aria-label="Tampilkan sidebar"
    aria-expanded="false">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('accordionSidebar');
        const mobileToggle = document.getElementById('sidebarMobileToggle');
        const backdrop = document.getElementById('sidebarBackdrop');
        const desktopToggle = document.getElementById('sidebarToggle');
        const topToggle = document.getElementById('sidebarToggleTop');
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
        attachHijack(topToggle, true);
    });
</script>