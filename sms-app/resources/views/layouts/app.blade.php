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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<div class="sms-layout">
    @include('partials.sidebar')

    <div class="main-content">
        <div class="topbar">
            <div>
                <div class="topbar-title">@yield('page_title')</div>
                <div class="topbar-breadcrumb">@yield('breadcrumb')</div>
            </div>

            <div class="topbar-actions">
                @if(auth()->user()->isSuperAdmin())
                    <form action="{{ route('campus.switch') }}" method="POST">
                        @csrf
                        <select class="filter-select" name="campus_id" onchange="this.form.submit()">
                            @foreach($layoutCampuses as $campus)
                                <option value="{{ $campus->id }}" @selected(optional($layoutActiveCampus)->id === $campus->id)>{{ $campus->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif

                @yield('topbar_actions')

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-outline-sms" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="page-body">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
