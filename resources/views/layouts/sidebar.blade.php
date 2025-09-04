<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">SIMPELKESOS Jampirogo</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{request()->is('dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Tables -->

    <li class="nav-item {{request()->is('residents*') ? 'active' : ''}}">
        <a class="nav-link" href="/residents">
            <i class="fas fa-fw fa-table"></i>
            <span>Penduduk</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item {{request()->is('peta*') ? 'active' : ''}}">
        <a class="nav-link" href="/peta">
            <i class="fas fa-fw fa-map"></i>
            <span>Peta</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>