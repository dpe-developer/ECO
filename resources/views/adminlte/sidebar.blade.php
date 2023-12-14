<aside class="main-sidebar elevation-4
    {{-- sidebar-light-danger --}}
    {{ Setting::ui('adminlte_sidebar_variant') }}
    {{ Setting::ui('adminlte_sidebar_disable_hover_focus_auto_expand') }}
    ">
    <!-- Brand Logo -->
    <a href="/" class="brand-link {{ Setting::ui('adminlte_brand_logo_variant') }}">
        <img src="{{ asset('storage/'.Setting::company('company_logo')) }}" alt="AdminLTE Logo" class="brand-image {{-- img-circle elevation-3 --}}" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.client_name', "Laravel AdminLTE") }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('storage/'.Auth::user()->getAvatar()) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('users.profile', Auth::user()->username) }}" class="d-block">{{ Auth::user()->first_name }}</a>
            </div>
        </div>
        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column
                {{ Setting::ui('adminlte_sidebar_nav_flat_style') }}
                {{ Setting::ui('adminlte_sidebar_nav_legacy_style') }}
                {{ Setting::ui('adminlte_sidebar_nav_compact') }}
                {{ Setting::ui('adminlte_sidebar_nav_child_indent') }}
                {{ Setting::ui('adminlte_sidebar_nav_child_hide_on_collapse') }}
                " data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon far fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @can('appointments.index')
                <li class="nav-item">
                    <a href="{{ route('appointments.index') }}" class="nav-link">
                        <i class="nav-icon far fa-calendar-check"></i>
                        <p>
                            Appointments
                            @if(Auth::user()->newAppointments()->count() > 0)
                                <span class="right badge badge-danger new-badge-count" badge-count="{{ Auth::user()->newAppointments()->count() }}">{{ Auth::user()->newAppointments()->count() }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                @endcan
                @can('patients.index')
                <li class="nav-item">
                    <a href="{{ route('patients.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-procedures"></i>
                        <p>
                            Patients
                        </p>
                    </a>
                </li>
                @endcan
                @can('announcements.index')
                <li class="nav-item">
                    <a href="{{ route('announcements.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-bullhorn"></i>
                        <p>
                            Announcements
                            @if(Auth::user()->newAnnouncements()->count() > 0)
                                <span class="right badge badge-danger new-badge-count" badge-count="{{ Auth::user()->newAnnouncements()->count() }}">{{ Auth::user()->newAnnouncements()->count() }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                @endcan
                @can('news_feeds.index')
                <li class="nav-item">
                    <a href="{{ route('news_feeds.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-newspaper"></i>
                        <p>
                            News Feed
                            @if(Auth::user()->newNewsFeeds()->count() > 0)
                                <span class="right badge badge-danger new-badge-count" badge-count="{{ Auth::user()->newNewsFeeds()->count() }}">{{ Auth::user()->newNewsFeeds()->count() }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                @endcan
                @canany([
                    'roles.index',
                    'users.index',
                    'settings.index',
                ])
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Configuration
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('roles.index')
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="far fa-angle-double-right nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        @endcan
                        @can('users.index')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link ">
                                <i class="far fa-angle-double-right nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        @endcan
                        @can('settings.index')
                        <li class="nav-item">
                            <a href="{{ route('settings.index') }}" class="nav-link">
                                <i class="far fa-angle-double-right nav-icon"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p>Logout</p>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
