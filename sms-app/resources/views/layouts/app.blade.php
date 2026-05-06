<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EduCore SMS')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sms.css') }}">
    @stack('styles')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
@if(session()->has('impersonator_id'))
    <div style="background: var(--charcoal); color: white; padding: 0.5rem 1.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; border-bottom: 1px solid var(--coral);">
        <div>
            <i class="bi bi-shield-lock-fill" style="color: var(--coral);"></i>
            <strong>Impersonation Mode:</strong> You are viewing <strong>{{ auth()->user()->school->name }}</strong> as an administrator.
        </div>
        <form action="{{ route('super-admin.leave-impersonation') }}" method="POST">
            @csrf
            <button type="submit" class="btn-primary-sms" style="padding: 0.2rem 0.75rem; font-size: 0.75rem; border-radius: 6px;">
                Return to Super Admin
            </button>
        </form>
    </div>
@endif
<div class="sms-layout">
    @if(request()->is('super-admin*'))
        @include('partials.super-admin-sidebar')
    @else
        @include('partials.sidebar')
    @endif

    <div class="main-content">
        <div class="topbar">
            <div>
                <div class="topbar-title">@yield('page_title')</div>
                <div class="topbar-breadcrumb">@yield('breadcrumb')</div>
            </div>

            <div class="topbar-actions">
                @if(request()->is('super-admin*'))
                    <div class="topbar-search d-none d-md-flex">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Search platform...">
                    </div>
                    <div class="topbar-icon-btn">
                        <i class="bi bi-bell"></i>
                        <div class="notif-badge">3</div>
                    </div>
                    <a class="topbar-icon-btn" href="{{ route('super-admin.profile.edit') }}" title="Profile">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <div class="topbar-icon-btn">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <div class="topbar-divider"></div>
                @endif

                @if(!request()->is('super-admin*') && (auth()->user()->isSuperAdmin() || auth()->user()->isCampusAdmin()))
                    @if(count($layoutCampuses) > 1)
                        <form action="{{ route('campus.switch') }}" method="POST">
                            @csrf
                            <select class="filter-select" name="campus_id" onchange="this.form.submit()">
                                @foreach($layoutCampuses as $campus)
                                    <option value="{{ $campus->id }}" @selected(optional($layoutActiveCampus)->id === $campus->id)>{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    @endif
                @endif

                @yield('topbar_actions')

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-outline-sms" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="page-body">
            @if(session('success'))
                <div class="alert-box tone-success" style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-box tone-danger" style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
