
<header class="topbar bg-white border-bottom shadow-sm">
    <nav class="navbar navbar-expand-md navbar-light py-2">

        <!-- Brand / Exit -->
        <div class="navbar-header d-flex align-items-center" id="topnav-logo-container">
            @if(request('dashboard_section') == 'settings')
                <a class="d-flex align-items-center text-primary fw-semibold" href="/home" id="settings-exit-button">
                    <i class="sl-icon-logout me-2"></i>{{ __('Exit Settings') }}
                </a>
            @else
                <a class="navbar-brand d-flex align-items-center" href="/home">
                    <img src="{{ runtimeLogoSmall() }}" alt="logo" class="me-2" height="28">
                    <img src="{{ runtimeLogoLarge() }}" alt="logo" class="d-none d-md-inline" height="28">
                </a>
            @endif
        </div>

        <!-- Left Controls -->
        <div class="collapse navbar-collapse" id="main-top-nav-bar">
            <ul class="navbar-nav me-auto">
                @if(request('visibility_left_menu_toggle_button') == 'visible')
                    <li class="nav-item">
                        <a class="nav-link sidebartoggler" href="javascript:void(0)">
                            <i class="sl-icon-menu fs-5"></i>
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Right Controls -->
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Notifications -->
                <li class="nav-item">
                    <a class="nav-link position-relative js-toggle-notifications-panel" href="javascript:void(0);">
                        <i class="sl-icon-bell fs-5"></i>
                        @if(auth()->user()->count_unread_notifications > 0)
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle border border-light"></span>
                        @endif
                    </a>
                </li>

                <!-- Notes -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/notes') }}">
                        <i class="ti ti-layers fs-5"></i>
                    </a>
                </li>

                <!-- Admin Settings -->
                @if(auth()->user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link" href="/settings">
                            <i class="sl-icon-settings fs-5"></i>
                        </a>
                    </li>
                @endif

                <!-- Language Switch -->
                @if(config('system.settings_system_language_allow_users_to_change') == 'yes')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="sl-icon-globe fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="langDropdown">
                            @foreach(request('system_languages') as $key => $language)
                                <li>
                                    <form id="langForm{{ $key }}" action="{{ url('user/updatelanguage') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="language" value="{{ $language }}">
                                        <input type="hidden" name="current_url" value="{{ url()->full() }}">
                                        <button type="submit" class="dropdown-item text-capitalize">
                                            {{ $language }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif

                <!-- Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" 
                             class="rounded-circle me-2 border border-light shadow-sm" 
                             width="36" height="36">
                        <span class="fw-semibold text-dark">{{ auth()->user()->first_name }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow profile-menu" aria-labelledby="userDropdown">
                        <li class="px-3 py-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" 
                                     class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <div class="fw-semibold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                </div>
                            </div>
                        </li>

                        <li><a class="dropdown-item" href="{{ url('/contacts/'.auth()->id().'/edit?type=profile') }}">
                            <i class="ti-user me-2 text-primary"></i> {{ __('My Profile') }}</a></li>

                        @if(auth()->user()->is_team && auth()->user()->role->role_timesheets >= 1)
                            <li><a class="dropdown-item" href="{{ url('/timesheets/my') }}">
                                <i class="ti-timer me-2 text-primary"></i> {{ __('My Timesheets') }}</a></li>
                        @endif

                        <li><a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#commonModal"
                            data-url="{{ url('user/updatenotifications') }}">
                            <i class="sl-icon-bell me-2 text-primary"></i> {{ __('Notification Settings') }}</a></li>

                        <li><a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#commonModal"
                            data-url="{{ url('user/updatetheme') }}">
                            <i class="ti-image me-2 text-primary"></i> {{ __('Change Theme') }}</a></li>

                        <li><a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#commonModal"
                            data-url="{{ url('user/updatepassword') }}">
                            <i class="ti-lock me-2 text-primary"></i> {{ __('Update Password') }}</a></li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-semibold">
                                    <i class="fa fa-power-off me-2"></i>{{ __('Logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
