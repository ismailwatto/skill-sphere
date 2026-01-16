<header class="top-navbar px-4">
    <div class="d-flex align-items-center flex-grow-1">
        <button class="btn btn-header-action me-3 d-lg-none" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="header-breadcrumb d-none d-md-flex align-items-center text-muted small me-4">
            <i class="bi bi-house-door me-2"></i>
            <span>SkillSphere</span>
            <i class="bi bi-chevron-right mx-2 extra-small opacity-50"></i>
            <span class="text-dark fw-medium">@yield('title', 'Dashboard')</span>
        </div>
        <h4 class="mb-0 fw-bold text-dark d-md-none">@yield('title', 'Dashboard')</h4>
    </div>
    
    <div class="ms-auto d-flex align-items-center gap-2">
        <div class="search-bar d-none d-lg-flex me-3">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control bg-light border-0" placeholder="Search anything...">
            </div>
        </div>

        <button class="btn btn-header-action rounded-circle" title="Notifications">
            <i class="bi bi-bell"></i>
            <span class="notification-badge"></span>
        </button>

        <a href="{{ route('chat.index') }}" class="btn btn-header-action rounded-circle" title="Live Chat">
            <i class="bi bi-chat-dots"></i>
        </a>
        
        <button class="btn btn-header-action rounded-circle d-none d-sm-flex" title="Quick Support">
            <i class="bi bi-question-circle"></i>
        </button>

        <div class="vr mx-2 opacity-10 d-none d-sm-block"></div>

        <div class="d-flex align-items-center gap-2 ms-1">
            <span class="extra-small fw-bold text-uppercase text-primary bg-primary-soft px-2 py-1 rounded">
                {{ Auth::user()->business ? Auth::user()->business->name : 'System Admin' }}
            </span>
        </div>
    </div>
</header>
