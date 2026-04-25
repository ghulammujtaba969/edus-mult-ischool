@extends('layouts.app')

@section('title', 'Register School | EduCore SaaS')
@section('page_title', 'Register New School')
@section('breadcrumb', '/ Super Admin / Schools / Create')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">School Information</div>
        <form action="{{ route('super-admin.schools.store') }}" method="POST" x-data="{ 
            schoolName: '{{ old('name') }}',
            schoolSlug: '{{ old('slug') }}',
            campusName: '{{ old('campus_name', 'Main Campus') }}',
            campusCode: '{{ old('campus_code') }}',
            updateSlug() {
                this.schoolSlug = this.schoolName.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
                if (!this.campusCode) {
                    this.campusCode = this.schoolName.split(' ').map(w => w[0]).join('').toUpperCase() + '-01';
                }
            }
        }">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">School Name</label>
                    <input type="text" name="name" x-model="schoolName" @input="updateSlug()" class="form-control-sms @error('name') is-invalid @enderror" placeholder="e.g. Oakridge Grammar School" required>
                    @error('name') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Unique Slug (for subdomain)</label>
                    <input type="text" name="slug" x-model="schoolSlug" class="form-control-sms @error('slug') is-invalid @enderror" placeholder="e.g. oakridge" required>
                    @error('slug') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms">Subscription Plan</label>
                    <select name="plan_id" class="form-control-sms @error('plan_id') is-invalid @enderror" required>
                        <option value="">-- Select Plan --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>{{ $plan->name }} ({{ $plan->max_branches }} Branches)</option>
                        @endforeach
                    </select>
                    @error('plan_id') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Initial Status</label>
                    <select name="status" class="form-control-sms @error('status') is-invalid @enderror" required>
                        <option value="active" @selected(old('status') == 'active')>Active</option>
                        <option value="pending" @selected(old('status') == 'pending')>Pending</option>
                        <option value="suspended" @selected(old('status') == 'suspended')>Suspended</option>
                    </select>
                    @error('status') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card-title" style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">Main Campus Details</div>
            <p class="muted" style="margin-bottom: 1.5rem; font-size: 0.875rem;">Every school needs at least one campus to begin operations.</p>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">Campus Name</label>
                    <input type="text" name="campus_name" x-model="campusName" class="form-control-sms @error('campus_name') is-invalid @enderror" placeholder="e.g. Main Campus" required>
                    @error('campus_name') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Campus Code</label>
                    <input type="text" name="campus_code" x-model="campusCode" class="form-control-sms @error('campus_code') is-invalid @enderror" placeholder="e.g. OGS-01" required>
                    @error('campus_code') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms">Campus City</label>
                    <input type="text" name="campus_city" class="form-control-sms @error('campus_city') is-invalid @enderror" value="{{ old('campus_city') }}" placeholder="e.g. Islamabad">
                    @error('campus_city') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Campus Phone</label>
                    <input type="text" name="campus_phone" class="form-control-sms @error('campus_phone') is-invalid @enderror" value="{{ old('campus_phone') }}" placeholder="e.g. 051-1234567">
                    @error('campus_phone') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card-title" style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">Admin Credentials</div>
            <p class="muted" style="margin-bottom: 1.5rem; font-size: 0.875rem;">Create the primary administrator account for this school.</p>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">Admin Name</label>
                    <input type="text" name="admin_name" class="form-control-sms @error('admin_name') is-invalid @enderror" value="{{ old('admin_name') }}" placeholder="e.g. John Doe" required>
                    @error('admin_name') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Admin Email</label>
                    <input type="email" name="admin_email" class="form-control-sms @error('admin_email') is-invalid @enderror" value="{{ old('admin_email') }}" placeholder="e.g. admin@school.com" required>
                    @error('admin_email') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;" x-data="{ 
                showPass: false,
                generatePass() {
                    const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    const lower = 'abcdefghijklmnopqrstuvwxyz';
                    const numbers = '0123456789';
                    const special = '!@#$%^&*()_+-=[]{}|;:,.<>?';
                    
                    // Ensure at least one of each
                    let pass = [
                        upper.charAt(Math.floor(Math.random() * upper.length)),
                        lower.charAt(Math.floor(Math.random() * lower.length)),
                        numbers.charAt(Math.floor(Math.random() * numbers.length)),
                        special.charAt(Math.floor(Math.random() * special.length))
                    ];
                    
                    // Fill the rest to 12 chars
                    const allChars = upper + lower + numbers + special;
                    for (let i = 0; i < 8; i++) {
                        pass.push(allChars.charAt(Math.floor(Math.random() * allChars.length)));
                    }
                    
                    // Shuffle the array
                    pass = pass.sort(() => Math.random() - 0.5).join('');
                    
                    $refs.adminPass.value = pass;
                    $refs.confirmPass.value = pass;
                    this.copyToClipboard(pass);
                },
                copyToClipboard(text) {
                    if (!text) return;
                    
                    // Primary method: Clipboard API
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
                        alert('Password generated and copied to clipboard (via fallback)!');
                    } catch (err) {
                        alert('Password generated, but could not copy automatically. Please copy it manually.');
                    }
                    document.body.removeChild(textArea);
                }
            }">
                <div>
                    <label class="form-label-sms">Password</label>
                    <div class="password-group-sms">
                        <input :type="showPass ? 'text' : 'password'" 
                               name="admin_password" 
                               x-ref="adminPass"
                               class="form-control-sms @error('admin_password') is-invalid @enderror" 
                               placeholder="••••••••" required>
                        <div class="password-actions-sms">
                            <button type="button" class="password-btn-sms" @click="showPass = !showPass" title="Toggle Visibility">
                                <i class="bi" :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                            <button type="button" class="password-btn-sms" @click="generatePass()" title="Generate & Copy">
                                <i class="bi bi-magic"></i>
                            </button>
                        </div>
                    </div>
                    @error('admin_password') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Confirm Password</label>
                    <input :type="showPass ? 'text' : 'password'" 
                           name="admin_password_confirmation" 
                           x-ref="confirmPass"
                           class="form-control-sms" 
                           placeholder="••••••••" required>
                </div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary-sms"><i class="bi bi-save"></i> Register School</button>
                <a href="{{ route('super-admin.schools.index') }}" class="btn-outline-sms">Cancel</a>
            </div>
        </form>
    </div>
@endsection
