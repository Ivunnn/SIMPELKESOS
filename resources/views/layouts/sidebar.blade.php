<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sidebar-sticky" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15"></div>
        <div class="sidebar-brand-text mx-3">SIMPELKESOS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->is('residents*') ? 'active' : '' }}">
        <a class="nav-link" href="/residents">
            <i class="fas fa-fw fa-table"></i>
            <span>Penduduk</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('map*') ? 'active' : '' }}">
        <a class="nav-link" href="/map">
            <i class="fas fa-fw fa-map"></i>
            <span>Peta</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('akun*') ? 'active' : '' }}">
        <a class="nav-link" href="/account">
            <i class="fas fa-fw fa-user"></i>
            <span>Akun</span>
        </a>
    </li>

@if(Auth::check() && Auth::user()->role === 'admin')
    <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Manajemen Pengguna</span>
        </a>
    </li>
@endif


    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>