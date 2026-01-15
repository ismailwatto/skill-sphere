<aside class="sidebar">
    <div class="sidebar-header">
        <div class="brand-wrapper">
            <i class="bi bi-shield-check brand-icon"></i>
            <span class="brand-text">SkillSphere</span>
        </div>
    </div>

    <div class="sidebar-menu flex-grow-1">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        @if(Auth::user()->role_id == 1) {{-- Super Admin --}}
        <a href="{{ route('businesses.index') }}" class="sidebar-link {{ request()->routeIs('businesses.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Customers
        </a>
        @endif

        @if(Auth::user()->business_id)
        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-person-workspace"></i> Staff Members
        </a>
        <a href="{{ route('products.index') }}" class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Products
        </a>
        <a href="{{ route('bookings.index') }}" class="sidebar-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
            <i class="bi bi-cart"></i> Bookings
        </a>
        <a href="{{ route('roles.index') }}" class="sidebar-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> Roles
        </a>
        @endif

        <div class="mt-auto pt-4 px-2">
            <div class="dropdown">
                <a href="#" class="user-snippet dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="avatar" class="rounded-circle" width="32" height="32">
                    <div class="overflow-hidden">
                        <div class="fw-bold small text-truncate text-white">{{ Auth::user()->name }}</div>
                        <div class="text-muted extra-small text-truncate">
                            {{ Auth::user()->role ? Auth::user()->role->name : (Auth::user()->business ? 'Owner' : 'Admin') }}
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark shadow border-0 mb-2 w-100 rounded-3" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item py-2 px-3 small mx-1 {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><hr class="dropdown-divider opacity-10"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 px-3 small text-danger mx-1">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
