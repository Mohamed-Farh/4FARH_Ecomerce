<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <livewire:backend.navbar.notification-component>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        @if(auth()->user()->ability('superAdmin', 'manage_users,show_users'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    Users
                </a>
            </li>
        @endif

        <div class="topbar-divider d-none d-sm-block"></div>

        @if(auth()->user()->ability('superAdmin', 'manage_admins,show_admins'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.admins.index') }}">
                    Admins
                </a>
            </li>
        @endif


        <div class="topbar-divider d-none d-sm-block"></div>


        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ \Auth::user()->full_name }}</span>
                @if (\Auth::user()->user_image != '')
                    <img class="img-profile rounded-circle" src="{{ asset('assets/users/' . \Auth::user()->user_image) }}" alt="{{ \Auth::user()->full_name }}">
                @else
                    <img class="img-profile rounded-circle" src="{{ asset('assets/users/avatar.png') }}">
                @endif
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ route('admin.mySettings') }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>

                <a href="javascript:void(0);" class="dropdown-item border-0" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout</a>
                <form method="POST" action="{{ route('logout') }}" id="logout-form"
                    class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
