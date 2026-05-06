<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon" style="background: var(--charcoal-mid); border: 1px solid var(--coral);">S</div>
        <div class="brand-name">SaaS<span>Admin</span></div>
    </div>

    <div class="sidebar-status">
        <div class="status-dot"></div>
        <div>
            <div class="status-label">System Status</div>
            <div class="status-name">Super Portal</div>
        </div>
    </div>

    <div class="nav-section-label">Main</div>
    <a class="nav-item @if(request()->routeIs('super-admin.dashboard')) active @endif" href="{{ route('super-admin.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section-label">Platform Management</div>
    <a class="nav-item @if(request()->routeIs('super-admin.schools.*')) active @endif" href="{{ route('super-admin.schools.index') }}">
        <i class="bi bi-building"></i> Schools
    </a>
    <a class="nav-item @if(request()->routeIs('super-admin.subscriptions.*')) active @endif" href="{{ route('super-admin.subscriptions.index') }}">
        <i class="bi bi-credit-card"></i> School Subscriptions
    </a>
    <a class="nav-item @if(request()->routeIs('super-admin.users.*')) active @endif" href="{{ route('super-admin.users.index') }}">
        <i class="bi bi-people"></i> Users
    </a>
    <a class="nav-item @if(request()->routeIs('super-admin.profile.*')) active @endif" href="{{ route('super-admin.profile.edit') }}">
        <i class="bi bi-person-circle"></i> Profile
    </a>
    <a class="nav-item @if(request()->routeIs('super-admin.plans.*')) active @endif" href="{{ route('super-admin.plans.index') }}">
        <i class="bi bi-card-list"></i> Subscription Plans
    </a>
    <a class="nav-item @if(request()->routeIs('super-admin.roles.*')) active @endif" href="{{ route('super-admin.roles.index') }}">
        <i class="bi bi-shield-lock"></i> Global Roles
    </a>
    <a class="nav-item @if(request()->routeIs('super-admin.permissions.*')) active @endif" href="{{ route('super-admin.permissions.index') }}">
        <i class="bi bi-key"></i> Permissions
    </a>
    <a class="nav-item @if(request()->routeIs('super-admin.domains.*')) active @endif" href="{{ route('super-admin.domains.index') }}">
        <i class="bi bi-globe"></i> Domain Requests
    </a>

    <div class="nav-section-label">System</div>
    <a class="nav-item @if(request()->routeIs('super-admin.settings.*')) active @endif" href="{{ route('super-admin.settings.index') }}">
        <i class="bi bi-gear"></i> Platform Settings
    </a>
    <a class="nav-item @if(request()->routeIs('super-admin.audit-logs.*')) active @endif" href="{{ route('super-admin.audit-logs.index') }}">
        <i class="bi bi-journal-text"></i> Audit Logs
    </a>

    <a class="sidebar-user" href="{{ route('super-admin.profile.edit') }}">
        <div class="user-avatar">{{ str(auth()->user()->name)->substr(0, 2)->upper() }}</div>
        <div>
            <div style="font-weight:700;">{{ auth()->user()->name }}</div>
            <div style="color:var(--charcoal-muted);font-size:.78rem;">Platform Master</div>
        </div>
    </a>
</aside>
