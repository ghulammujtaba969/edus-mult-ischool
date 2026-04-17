<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EduCore SMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sms.css') }}">
</head>
<body>
<div class="page-login">
    <div class="login-left">
        <div class="login-copy">
            <div class="login-brand">
                <div class="brand-icon">E</div>
                <div class="brand-name">Edu<span>Core</span></div>
            </div>
            <h1>Multi-campus control for modern <span style="color:var(--coral);">school operations</span></h1>
            <p>Admin-focused MVP with student records, live dashboards, fee tracking, attendance foundations, and exam-ready academic data.</p>
            <div class="login-stats">
                <div><div style="font-size:1.7rem;font-weight:800;">2,418</div><div class="muted">Students</div></div>
                <div><div style="font-size:1.7rem;font-weight:800;">91.4%</div><div class="muted">Attendance</div></div>
                <div><div style="font-size:1.7rem;font-weight:800;">PKR 4.2M</div><div class="muted">Monthly fees</div></div>
            </div>
        </div>
    </div>

    <div class="login-right">
        <div class="auth-card">
            <h2 style="margin:0;font-size:2rem;">Sign in</h2>
            <p class="muted">Use the seeded campus admin account to access the MVP.</p>

            @if($errors->any())
                <div class="alert-box">{{ $errors->first() }}</div>
            @endif

            <div class="role-tabs">
                <button class="role-tab active" type="button">Admin</button>
                <button class="role-tab" type="button">Teacher</button>
                <button class="role-tab" type="button">Parent</button>
            </div>

            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <div style="margin-bottom:1rem;">
                    <label class="form-label-sms" for="email">Email</label>
                    <input class="form-control-sms" id="email" name="email" type="email" value="{{ old('email', 'admin@alfalah.edu.pk') }}" required>
                </div>
                <div style="margin-bottom:1rem;">
                    <label class="form-label-sms" for="password">Password</label>
                    <input class="form-control-sms" id="password" name="password" type="password" value="password" required>
                </div>
                <label style="display:flex;gap:.5rem;align-items:center;margin-bottom:1rem;">
                    <input type="checkbox" name="remember" value="1" checked>
                    <span class="muted">Keep me signed in</span>
                </label>
                <button class="btn-login" type="submit">Enter dashboard</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
