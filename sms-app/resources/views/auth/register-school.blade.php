<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your School | EduCore SaaS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sms.css') }}">
    <style>
        body { background: var(--bg-light); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 2rem; }
        .register-card { background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); width: 100%; max-width: 900px; display: grid; grid-template-columns: 1fr 1.2fr; overflow: hidden; }
        .register-info { background: var(--primary); color: white; padding: 3rem; display: flex; flex-direction: column; justify-content: center; }
        .register-form { padding: 3rem; }
        .form-title { font-size: 1.5rem; font-weight: 800; color: var(--charcoal); margin-bottom: .5rem; }
        .form-subtitle { color: var(--text-light); font-size: .9rem; margin-bottom: 2rem; }
        .feature-item { display: flex; gap: 1rem; margin-bottom: 1.5rem; }
        .feature-icon { width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        @media (max-width: 768px) { .register-card { grid-template-columns: 1fr; } .register-info { display: none; } }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-info">
            <div style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem;">EduCore SaaS</div>
            <h2 style="margin-bottom: 1.5rem;">Launch your school platform in minutes.</h2>
            
            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                <div>
                    <div style="font-weight: 700;">Multi-Campus Ready</div>
                    <div style="font-size: .85rem; opacity: .8;">Manage all your branches from a single dashboard.</div>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-lightning-charge"></i></div>
                <div>
                    <div style="font-weight: 700;">Instant Setup</div>
                    <div style="font-size: .85rem; opacity: .8;">Get your own subdomain and start enrolling students immediately.</div>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                <div>
                    <div style="font-weight: 700;">Scalable Solution</div>
                    <div style="font-size: .85rem; opacity: .8;">From 100 to 10,000+ students, we grow with you.</div>
                </div>
            </div>
        </div>

        <div class="register-form">
            <div class="form-title">Start Your 14-Day Free Trial</div>
            <div class="form-subtitle">No credit card required. Cancel anytime.</div>

            @if(session('error'))
                <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: .85rem;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label-sms">School Name</label>
                    <input type="text" name="school_name" class="form-control-sms @error('school_name') is-invalid @enderror" value="{{ old('school_name') }}" placeholder="e.g. St. Peters Academy" required>
                    @error('school_name') <div style="color:var(--danger); font-size:.75rem; margin-top:.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label-sms">Desired Subdomain</label>
                    <div style="display: flex; align-items: center; gap: .5rem;">
                        <input type="text" name="slug" class="form-control-sms @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="school-name" style="flex: 1;" required>
                        <span style="font-weight: 600; color: var(--text-light);">.{{ parse_url(config('app.url'), PHP_URL_HOST) }}</span>
                    </div>
                    @error('slug') <div style="color:var(--danger); font-size:.75rem; margin-top:.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label class="form-label-sms">Admin Name</label>
                        <input type="text" name="admin_name" class="form-control-sms @error('admin_name') is-invalid @enderror" value="{{ old('admin_name') }}" placeholder="Full Name" required>
                    </div>
                    <div>
                        <label class="form-label-sms">Admin Email</label>
                        <input type="email" name="admin_email" class="form-control-sms @error('admin_email') is-invalid @enderror" value="{{ old('admin_email') }}" placeholder="email@example.com" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label class="form-label-sms">Password</label>
                        <input type="password" name="admin_password" class="form-control-sms @error('admin_password') is-invalid @enderror" required>
                    </div>
                    <div>
                        <label class="form-label-sms">Confirm Password</label>
                        <input type="password" name="admin_password_confirmation" class="form-control-sms" required>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label class="form-label-sms">Choose a Plan</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: .75rem;">
                        @foreach($plans as $plan)
                            <label style="border: 2px solid var(--border-color); border-radius: 10px; padding: 1rem; cursor: pointer; display: block; position: relative;">
                                <input type="radio" name="plan_id" value="{{ $plan->id }}" @checked(old('plan_id') == $plan->id || $loop->first) style="position: absolute; right: 1rem; top: 1.2rem;">
                                <div style="font-weight: 800; color: var(--primary);">{{ $plan->name }}</div>
                                <div style="font-size: .75rem; color: var(--text-light);">{{ $plan->max_branches }} Branches</div>
                                <div style="font-weight: 700; margin-top: .25rem;">${{ number_format($plan->monthly_price, 0) }}/mo</div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn-primary-sms w-full" style="padding: 1rem; font-size: 1rem;"><i class="bi bi-rocket-takeoff"></i> Create My School</button>
                
                <div style="text-align: center; margin-top: 1.5rem; font-size: .85rem; color: var(--text-light);">
                    Already have an account? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">Login here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
