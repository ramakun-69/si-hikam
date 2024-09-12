<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __("Dashboard") }}</span></a>
    </li>
    <li class="nav-item {{ Request::is('leave-request/*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#leave"
            aria-expanded="true" aria-controls="leave">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>{{ __("Leave Request") }}</span>
        </a>
        <div id="leave" class="collapse {{ Request::is('leave-request/*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
               
                <a class="collapse-item" href="{{ route('type-of-leave.index') }}">{{ __("Type Of Leave") }}</a>
                <a class="collapse-item" href="{{ url('todo/edit') }}">{{ __("Leave Request List") }}</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ Request::is('attendance/*') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('attendance.check-in') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>{{ __("Check In") }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('qr_code') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>{{ __("Check Out") }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('user') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>{{ __("Daily Attendences") }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __("User") }}</span></a>
    </li>
   

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
