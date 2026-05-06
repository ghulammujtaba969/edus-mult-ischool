@extends('layouts.app')

@section('title', 'My Profile | SaaSAdmin')
@section('page_title', 'My Profile')
@section('breadcrumb', 'Super Admin / Profile')

@section('content')
<div class="saas-page-head">
    <div>
        <span class="eyebrow">Account Center</span>
        <h1>My Profile</h1>
        <p>Manage your platform identity, security, and admin session details.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('super-admin.users.permissions', $user) }}" class="btn-outline-sms">
            <i class="bi bi-shield-check"></i> Permissions
        </a>
    </div>
</div>

<div class="profile-layout-saas">
    <aside class="profile-card-saas">
        <div class="profile-cover"></div>
        <div class="profile-avatar-xl">{{ str($user->name)->substr(0, 2)->upper() }}</div>
        <h2>{{ $user->name }}</h2>
        <p>{{ Str::of($user->role->value ?? (string) $user->role)->replace('_', ' ')->title() }}</p>
        <span class="status-pill pill-active"><i class="bi bi-check-circle"></i> Active</span>

        <div class="profile-mini-stats">
            <div><strong>{{ $user->permissions->count() }}</strong><span>Direct perms</span></div>
            <div><strong>{{ $user->created_at->diffInDays(now()) }}</strong><span>Days</span></div>
            <div><strong>{{ $user->last_login_at?->diffForHumans() ?? 'New' }}</strong><span>Login</span></div>
        </div>

        <div class="profile-contact-list">
            <div><i class="bi bi-envelope"></i><span>{{ $user->email }}</span></div>
            <div><i class="bi bi-telephone"></i><span>{{ $user->phone ?: 'No phone added' }}</span></div>
            <div><i class="bi bi-building"></i><span>{{ $user->school->name ?? 'Platform account' }}</span></div>
        </div>
    </aside>

    <div class="profile-stack">
        <form action="{{ route('super-admin.profile.update') }}" method="POST" class="card-sms saas-form-card">
            @csrf
            @method('PUT')

            <div class="section-heading-saas">
                <div class="section-icon coral"><i class="bi bi-person"></i></div>
                <div>
                    <h3>Personal Details</h3>
                    <p>These details appear in the super-admin portal and audit trail.</p>
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label class="form-label-sms" for="name">Full Name</label>
                    <input id="name" name="name" class="form-control-sms @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="email">Email Address</label>
                    <input id="email" type="email" name="email" class="form-control-sms @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="phone">Phone</label>
                    <input id="phone" name="phone" class="form-control-sms @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="+92 300 0000000">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Role</label>
                    <input class="form-control-sms" value="{{ Str::of($user->role->value ?? (string) $user->role)->replace('_', ' ')->title() }}" disabled>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-check-lg"></i> Save Profile</button>
            </div>
        </form>

        <form action="{{ route('super-admin.profile.password') }}" method="POST" class="card-sms saas-form-card">
            @csrf
            @method('PUT')

            <div class="section-heading-saas">
                <div class="section-icon warning"><i class="bi bi-shield-lock"></i></div>
                <div>
                    <h3>Security</h3>
                    <p>Change your password without leaving the admin workspace.</p>
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label class="form-label-sms" for="current_password">Current Password</label>
                    <input id="current_password" type="password" name="current_password" class="form-control-sms @error('current_password') is-invalid @enderror" autocomplete="current-password">
                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="password">New Password</label>
                    <input id="password" type="password" name="password" class="form-control-sms @error('password') is-invalid @enderror" autocomplete="new-password">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control-sms" autocomplete="new-password">
                </div>
            </div>

            <div class="form-actions">
                <button class="btn-outline-sms" type="submit"><i class="bi bi-key"></i> Update Password</button>
            </div>
        </form>

        <div class="card-sms saas-form-card">
            <div class="section-heading-saas">
                <div class="section-icon info"><i class="bi bi-clock-history"></i></div>
                <div>
                    <h3>Session Snapshot</h3>
                    <p>Quick operational context for this admin account.</p>
                </div>
            </div>
            <div class="info-grid-3">
                <div class="info-field"><label>Account ID</label><strong class="mono">USR-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</strong></div>
                <div class="info-field"><label>Created</label><strong>{{ $user->created_at->format('M d, Y') }}</strong></div>
                <div class="info-field"><label>Updated</label><strong>{{ $user->updated_at->diffForHumans() }}</strong></div>
            </div>
        </div>
    </div>
</div>
@endsection
