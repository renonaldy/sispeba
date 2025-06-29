<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base bx bx-menu icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center me-auto">
            <div class="nav-item d-flex align-items-center">
                <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span>
                <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none"
                    placeholder="Search..." aria-label="Search..." />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
            <!-- User -->
            @auth
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="#" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            @if (auth()->user()->role == 'admin')
                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                    class="w-px-40 h-auto rounded-circle" />
                            @elseif(auth()->user()->role == 'kurir')
                                <img src="{{ asset('assets/img/avatars/2.png') }}" alt
                                    class="w-px-40 h-auto rounded-circle" />
                            @else
                                <img src="{{ asset('assets/img/avatars/4.png') }}" alt
                                    class="w-px-40 h-auto rounded-circle" />
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            @if (auth()->user()->role == 'admin')
                                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                                    class="w-px-40 h-auto rounded-circle" />
                                            @elseif(auth()->user()->role == 'kurir')
                                                <img src="{{ asset('assets/img/avatars/2.png') }}" alt
                                                    class="w-px-40 h-auto rounded-circle" />
                                            @else
                                                <img src="{{ asset('assets/img/avatars/4.png') }}" alt
                                                    class="w-px-40 h-auto rounded-circle" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                        <small
                                            class="text-body-secondary text-capitalize">{{ auth()->user()->role }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider my-1"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
    </div>
</nav>
