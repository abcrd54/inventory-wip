<header class="pc-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">

            {{-- LEFT --}}
            <div class="d-flex align-items-center">
                <a href="#" id="sidebar-hide" class="pc-head-link">
                    <i class="ti ti-menu-2"></i>
                </a>
            </div>

            {{-- RIGHT : PROFILE (CUSTOM, MANTIS STYLE) --}}
            <div class="mantis-profile dropdown">
                <a href="#"
                   class="mantis-profile-trigger"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">

                    <span class="mantis-avatar">
                        <i class="ti ti-user"></i>
                    </span>

                    <span class="mantis-username">
                        {{ auth()->user()->username }}
                    </span>

                    <i class="ti ti-chevron-down mantis-caret"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow-sm">
                    <a class="dropdown-item" href="#">
                        <i class="ti ti-id me-2"></i> Profile
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="ti ti-logout me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
