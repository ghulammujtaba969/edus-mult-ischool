<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">E</div>
        <div class="brand-name">Edu<span>Core</span></div>
    </div>

    <div class="session-badge">
        <div class="session-dot"></div>
        <div>
            <div style="font-size:.75rem;color:var(--charcoal-muted);">Academic Year</div>
            <div style="font-weight:700;">{{ $layoutAcademicYear?->name ?? 'Not set' }}</div>
        </div>
    </div>

    <div class="nav-section-label">Main</div>
    <a class="nav-item @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
    <a class="nav-item @if(request()->routeIs('admin.students.*')) active @endif" href="{{ route('admin.students.index') }}"><i class="bi bi-mortarboard-fill"></i> Students <span class="nav-badge">MVP</span></a>
    <a class="nav-item @if(request()->routeIs('admin.employees.*')) active @endif" href="{{ route('admin.employees.index') }}"><i class="bi bi-person-badge-fill"></i> Staff</a>
    <a class="nav-item @if(request()->routeIs('admin.payrolls.*')) active @endif" href="{{ route('admin.payrolls.index') }}"><i class="bi bi-cash-stack"></i> Payroll</a>
    <a class="nav-item @if(request()->routeIs('admin.notifications.*')) active @endif" href="{{ route('admin.notifications.index') }}"><i class="bi bi-bell-fill"></i> Notifications</a>
    <a class="nav-item @if(request()->routeIs('admin.reports.*')) active @endif" href="{{ route('admin.reports.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Reports</a>
    
    <div class="nav-section-label">Resources</div>
    <a class="nav-item @if(request()->routeIs('admin.hostels.*') || request()->routeIs('admin.hostel-allocations.*')) active @endif" href="{{ route('admin.hostels.index') }}"><i class="bi bi-house-door-fill"></i> Hostel</a>
    <a class="nav-item @if(request()->routeIs('admin.assets.*') || request()->routeIs('admin.asset-assignments.*')) active @endif" href="{{ route('admin.assets.index') }}"><i class="bi bi-box-seam-fill"></i> Assets</a>

    <div class="nav-section-label">Academic</div>
    @if(auth()->user()->isSuperAdmin())
        <a class="nav-item @if(request()->routeIs('admin.campuses.*')) active @endif" href="{{ route('admin.campuses.index') }}"><i class="bi bi-buildings"></i> Campuses</a>
    @endif
    <a class="nav-item @if(request()->routeIs('admin.academic-years.*')) active @endif" href="{{ route('admin.academic-years.index') }}"><i class="bi bi-calendar-range"></i> Academic Years</a>
    <a class="nav-item @if(request()->routeIs('admin.classes.*')) active @endif" href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i> Classes</a>
    <a class="nav-item @if(request()->routeIs('admin.sections.*')) active @endif" href="{{ route('admin.sections.index') }}"><i class="bi bi-grid-3x3-gap"></i> Sections</a>
    <a class="nav-item @if(request()->routeIs('admin.subjects.*')) active @endif" href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i> Subjects</a>
    <a class="nav-item @if(request()->routeIs('admin.attendance.*')) active @endif" href="{{ route('admin.attendance.index') }}"><i class="bi bi-check2-square"></i> Attendance</a>

    <div class="nav-section-label">Examinations</div>
    <a class="nav-item @if(request()->routeIs('admin.exam-types.*')) active @endif" href="{{ route('admin.exam-types.index') }}"><i class="bi bi-gear"></i> Exam Types</a>
    <a class="nav-item @if(request()->routeIs('admin.exams.*')) active @endif" href="{{ route('admin.exams.index') }}"><i class="bi bi-calendar-check"></i> Schedules</a>
    <a class="nav-item @if(request()->routeIs('admin.marks.*')) active @endif" href="{{ route('admin.marks.index') }}"><i class="bi bi-pencil-square"></i> Marks Entry</a>
    <button class="nav-item" type="button"><i class="bi bi-file-earmark-pdf"></i> Result Cards</button>

    <div class="nav-section-label">Finance</div>
    <a class="nav-item @if(request()->routeIs('admin.fee-types.*')) active @endif" href="{{ route('admin.fee-types.index') }}"><i class="bi bi-tags"></i> Fee Types</a>
    <a class="nav-item @if(request()->routeIs('admin.fee-structures.*')) active @endif" href="{{ route('admin.fee-structures.index') }}"><i class="bi bi-calculator"></i> Fee Structures</a>
    <a class="nav-item @if(request()->routeIs('admin.fee-invoices.*')) active @endif" href="{{ route('admin.fee-invoices.index') }}"><i class="bi bi-receipt"></i> Fee Invoices</a>
    <button class="nav-item" type="button"><i class="bi bi-cash-stack"></i> Expenses</button>

    <div class="sidebar-user">
        <div class="user-avatar">{{ str(auth()->user()->name)->substr(0, 2)->upper() }}</div>
        <div>
            <div style="font-weight:700;">{{ auth()->user()->name }}</div>
            <div style="color:var(--charcoal-muted);font-size:.78rem;">{{ auth()->user()->role->label() }}</div>
        </div>
    </div>
</aside>
