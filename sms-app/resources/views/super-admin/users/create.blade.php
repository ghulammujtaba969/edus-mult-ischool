@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms" style="padding: 0.5rem; border-radius: 8px; border: 1px solid #e2e8f0; color: #64748b;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--charcoal); margin: 0;">Add New User</h1>
            <p style="color: #64748b; margin-top: 0.25rem;">Create a new user and assign them to a school</p>
        </div>
    </div>
</div>

<div class="card" style="background: white; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); max-width: 800px;">
    <div style="padding: 2rem;">
        <form action="{{ route('super-admin.users.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. John Doe">
                    @error('name') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="e.g. john@example.com">
                    @error('email') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;" x-data="{
                showPass: false,
                generatePass() {
                    const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    const lower = 'abcdefghijklmnopqrstuvwxyz';
                    const numbers = '0123456789';
                    const special = '!@#$%^&*()_+-=[]{}|;:,.<>?';

                    let pass = [
                        upper.charAt(Math.floor(Math.random() * upper.length)),
                        lower.charAt(Math.floor(Math.random() * lower.length)),
                        numbers.charAt(Math.floor(Math.random() * numbers.length)),
                        special.charAt(Math.floor(Math.random() * special.length))
                    ];

                    const allChars = upper + lower + numbers + special;
                    for (let i = 0; i < 8; i++) {
                        pass.push(allChars.charAt(Math.floor(Math.random() * allChars.length)));
                    }

                    pass = pass.sort(() => Math.random() - 0.5).join('');

                    $refs.userPass.value = pass;
                    $refs.confirmPass.value = pass;
                    this.copyToClipboard(pass);
                },
                copyToClipboard(text) {
                    if (!text) return;
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(text).then(() => {
                            alert('Password generated and copied to clipboard!');
                        }).catch(err => {
                            this.fallbackCopy(text);
                        });
                    } else {
                        this.fallbackCopy(text);
                    }
                },
                fallbackCopy(text) {
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-9999px';
                    textArea.style.top = '0';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        alert('Password generated and copied to clipboard!');
                    } catch (err) {
                        alert('Password generated, but could not copy automatically.');
                    }
                    document.body.removeChild(textArea);
                }
            }">
                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Password</label>
                    <div class="password-group-sms">
                        <input :type="showPass ? 'text' : 'password'"
                               name="password"
                               x-ref="userPass"
                               class="form-control"
                               required
                               placeholder="Minimum 8 characters">
                        <div class="password-actions-sms">
                            <button type="button" class="password-btn-sms" @click="showPass = !showPass" title="Toggle Visibility">
                                <i class="bi" :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                            <button type="button" class="password-btn-sms" @click="generatePass()" title="Generate & Copy">
                                <i class="bi bi-magic"></i>
                            </button>
                        </div>
                    </div>
                    @error('password') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Confirm Password</label>
                    <input :type="showPass ? 'text' : 'password'"
                           name="password_confirmation"
                           x-ref="confirmPass"
                           class="form-control"
                           required
                           placeholder="Repeat password">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">School</label>
                    <select name="school_id" class="form-control">
                        <option value="">Platform Wide (No School)</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" @selected(old('school_id', $selectedSchoolId) == $school->id)>{{ $school->name }}</option>
                        @endforeach
                    </select>
                    @error('school_id') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->value }}" @selected(old('role', $selectedRole) == $role->value)>{{ $role->label() }}</option>
                        @endforeach
                    </select>
                    @error('role') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
                    <span style="font-weight: 600; color: #475569;">Active Account</span>
                </label>
                <p style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem; margin-left: 1.75rem;">Inactive users cannot log into the platform.</p>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms" style="padding: 0.75rem 1.5rem; border-radius: 8px; border: 1px solid #e2e8f0; color: #64748b; font-weight: 600;">Cancel</a>
                <button type="submit" class="btn-primary-sms" style="padding: 0.75rem 2rem; border-radius: 8px; background: var(--charcoal); color: white; font-weight: 600; border: none; cursor: pointer;">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    outline: none;
    font-size: 0.95rem;
    transition: border-color 0.2s;
}
.form-control:focus {
    border-color: var(--coral);
}
</style>
@endsection
