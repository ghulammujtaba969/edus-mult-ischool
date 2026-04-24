<div class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="bi bi-shield-lock-fill"></i>
            <span>SaaS Admin</span>
        </div>
    </div>

    <div class="nav-section">
        <a class="nav-item @if(request()->routeIs('super-admin.dashboard')) active @endif" href="{{ route('super-admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        
        <div class="nav-section-label">Platform Management</div>
        <a class="nav-item @if(request()->routeIs('super-admin.schools.*')) active @endif" href="{{ route('super-admin.schools.index') }}">
            <i class="bi bi-building"></i> Schools
        </a>
        <a class="nav-item @if(request()->routeIs('super-admin.plans.*')) active @endif" href="#">
            <i class="bi bi-card-list"></i> Subscription Plans
        </a>
        <a class="nav-item @if(request()->routeIs('super-admin.domains.*')) active @endif" href="#">
            <i class="bi bi-globe"></i> Domain Requests
        </a>

        <div class="nav-section-label">System</div>
        <a class="nav-item" href="#">
            <i class="bi bi-gear"></i> Platform Settings
        </a>
        <a class="nav-item" href="#">
            <i class="bi bi-journal-text"></i> Audit Logs
        </a>
    </div>

    <div class="sidebar-footer">
        <div style="font-size:.75rem;color:var(--charcoal-muted);">Logged in as</div>
        <div style="font-weight:700;font-size:.85rem;color:var(--charcoal);">{{ auth()->user()->name }}</div>
    </div>
</div>
