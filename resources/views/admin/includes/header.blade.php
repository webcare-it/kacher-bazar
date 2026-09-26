<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            <div class="search-bar flex-grow-1">
                <div class="position-relative search-bar-box">
                    <input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
                    <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
                </div>
            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li>
                        <a href="{{url('/')}}" target="_blank" class="btn btn-primary w-100">
                            Visit Website
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.cache.clear') }}" class="btn btn-warning mx-2" onclick="return confirm('Are you sure you want to clear all caches?')">
                            <i class='bx bx-refresh'></i> Clear Cache
                        </a>
                    </li>
                </ul>
            </div>
            <div class="user-box dropdown">
                <!-- Trigger -->
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <img src="https://via.placeholder.com/110x110" class="user-img" alt="user avatar"> --}}
                    <div class="user-info ps-3 d-flex align-items-center gap-1">
                        <p class="user-name mb-0">Admin</p>
                        <i class='bx bx-chevron-down'></i> <!-- Arrow icon -->
                    </div>
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{url('/settings')}}">
                            <i class="bx bx-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>

                    <li><div class="dropdown-divider mb-0"></div></li>

                    <li>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <i class='bx bx-log-out-circle'></i>
                            <span>Logout</span>
                        </a>

                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

