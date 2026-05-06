@extends('layouts.app')

@section('title', 'Edit School | SaaSAdmin')
@section('page_title', 'Edit School')
@section('breadcrumb', 'Super Admin / Schools / Edit')

@php
    $featureValues = $school->feature_toggles ?? [];
    $tagValue = old('tags', implode(', ', $school->tags ?? []));
    $logoUrl = $school->logo ? asset('storage/' . $school->logo) : null;
@endphp

@section('content')
<form action="{{ route('super-admin.schools.update', $school) }}" method="POST" enctype="multipart/form-data" class="add-school-form" x-data="{
    schoolName: @js(old('name', $school->name)),
    schoolSlug: @js($school->slug),
    campusName: @js(old('campus_name', $mainCampus->name ?? 'Main Campus')),
    campusCode: @js(old('campus_code', $mainCampus->code ?? '')),
    showPass: false,
    generatePass() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
        let pass = '';
        for (let i = 0; i < 12; i++) pass += chars[Math.floor(Math.random() * chars.length)];
        $refs.adminPass.value = pass;
        $refs.confirmPass.value = pass;
        navigator.clipboard?.writeText(pass);
    }
}">
    @csrf
    @method('PUT')

    <div class="schools-head">
        <div>
            <h1>Edit School - <span>{{ $school->name }}</span></h1>
            <p>{{ $school->registration_number ?? 'SCH-' . str_pad($school->id, 5, '0', STR_PAD_LEFT) }} · {{ $school->plan->name ?? 'No plan' }} · Last updated {{ $school->updated_at->diffForHumans() }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('super-admin.schools.index') }}" class="btn-outline-sms"><i class="bi bi-arrow-left"></i> Back to List</a>
            <button type="submit" class="btn-primary-sms"><i class="bi bi-check-lg"></i> Update School</button>
        </div>
    </div>

    <div class="form-steps-card">
        <div class="form-steps">
            <div class="step-item done"><span><i class="bi bi-check-lg"></i></span><div><strong>Basic Info</strong><small>School details</small></div></div>
            <div class="step-line done"></div>
            <div class="step-item done"><span><i class="bi bi-check-lg"></i></span><div><strong>Configuration</strong><small>Plan & settings</small></div></div>
            <div class="step-line done"></div>
            <div class="step-item active"><span>3</span><div><strong>Admin Account</strong><small>Owner details</small></div></div>
            <div class="step-line"></div>
            <div class="step-item"><span>4</span><div><strong>Review</strong><small>Confirm & update</small></div></div>
        </div>
    </div>

    <div class="add-school-layout">
        <main class="add-school-main">
            <section class="card-sms form-panel">
                <div class="section-heading-saas">
                    <div class="section-icon coral"><i class="bi bi-building"></i></div>
                    <div><h3>School Identity</h3><p>Basic information and branding</p></div>
                </div>

                <div class="avatar-upload">
                    @if($logoUrl)
                        <img class="avatar-preview image" src="{{ $logoUrl }}" alt="{{ $school->name }} logo">
                    @else
                        <div class="avatar-preview" x-text="schoolName ? schoolName.charAt(0).toUpperCase() : 'S'"></div>
                    @endif
                    <div>
                        <h4>School Logo</h4>
                        <p>Upload a new PNG/JPG/WebP to replace the current logo. Max 2MB.</p>
                        <label class="btn-outline-sms btn-small upload-btn"><i class="bi bi-upload"></i> Replace Logo <input type="file" name="logo" accept="image/png,image/jpeg,image/webp"></label>
                        @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label-sms">School Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" x-model="schoolName" class="form-control-sms @error('name') is-invalid @enderror" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Official Short Name</label>
                        <input type="text" name="short_name" value="{{ old('short_name', $school->short_name) }}" class="form-control-sms @error('short_name') is-invalid @enderror" placeholder="e.g. LGS">
                        @error('short_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Registration Number</label>
                        <div class="input-prefix-wrap"><span>SCH-</span><input type="text" name="registration_number" value="{{ Str::after(old('registration_number', $school->registration_number), 'SCH-') }}" class="form-control-sms @error('registration_number') is-invalid @enderror"></div>
                        @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Slug</label>
                        <input type="text" class="form-control-sms" x-model="schoolSlug" disabled>
                        <small class="field-hint">Slug remains locked after registration.</small>
                    </div>
                </div>

                <div class="form-grid cols-3 mt-3">
                    <div><label class="form-label-sms">Established Year</label><input type="number" name="established_year" value="{{ old('established_year', $school->established_year) }}" min="1800" max="{{ now()->year }}" class="form-control-sms @error('established_year') is-invalid @enderror">@error('established_year') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div>
                        <label class="form-label-sms">Country <span class="text-danger">*</span></label>
                        <select name="country" class="form-control-sms @error('country') is-invalid @enderror">
                            @foreach(['Pakistan', 'UAE', 'Saudi Arabia'] as $country)
                                <option value="{{ $country }}" @selected(old('country', $school->country ?? 'Pakistan') === $country)>{{ $country }}</option>
                            @endforeach
                        </select>
                        @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Province / State</label>
                        <select name="province" class="form-control-sms @error('province') is-invalid @enderror">
                            @foreach(['Punjab', 'Sindh', 'KPK', 'Balochistan'] as $province)
                                <option value="{{ $province }}" @selected(old('province', $school->province) === $province)>{{ $province }}</option>
                            @endforeach
                        </select>
                        @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">City</label>
                        <input type="text" name="campus_city" value="{{ old('campus_city', $mainCampus->city ?? $school->city) }}" class="form-control-sms @error('campus_city') is-invalid @enderror">
                        @error('campus_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label-sms">School Description</label>
                    <textarea name="description" class="form-control-sms form-textarea @error('description') is-invalid @enderror">{{ old('description', $school->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mt-3">
                    <label class="form-label-sms">Full Address</label>
                    <input type="text" name="address" value="{{ old('address', $school->address ?? $mainCampus->address ?? null) }}" class="form-control-sms @error('address') is-invalid @enderror">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </section>

            <section class="card-sms form-panel">
                <div class="section-heading-saas">
                    <div class="section-icon info"><i class="bi bi-telephone"></i></div>
                    <div><h3>Contact & Communication</h3><p>Primary contact details for this school</p></div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label-sms">Official Email <span class="text-danger">*</span></label>
                        <div class="input-icon-left"><i class="bi bi-envelope"></i><input type="email" name="official_email" value="{{ old('official_email', $school->official_email) }}" class="form-control-sms @error('official_email') is-invalid @enderror" required></div>
                        @error('official_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Phone Number</label>
                        <div class="input-prefix-wrap"><span>+92</span><input type="text" name="phone" value="{{ old('phone', $school->phone) }}" class="form-control-sms @error('phone') is-invalid @enderror"></div>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Website</label>
                        <div class="input-prefix-wrap wide"><span>https://</span><input type="text" name="website" value="{{ old('website', $school->website) }}" class="form-control-sms @error('website') is-invalid @enderror"></div>
                        @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Custom Subdomain</label>
                        <div class="input-suffix-wrap"><input type="text" name="custom_subdomain" value="{{ old('custom_subdomain', $school->custom_subdomain ?: $school->slug) }}" class="form-control-sms @error('custom_subdomain') is-invalid @enderror"><span>.educore.app</span></div>
                        @error('custom_subdomain') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-grid cols-3 mt-3">
                    <div><label class="form-label-sms">WhatsApp</label><input type="text" name="whatsapp" value="{{ old('whatsapp', $school->whatsapp) }}" class="form-control-sms @error('whatsapp') is-invalid @enderror">@error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Twitter / X</label><input type="text" name="twitter" value="{{ old('twitter', $school->twitter) }}" class="form-control-sms @error('twitter') is-invalid @enderror">@error('twitter') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Facebook</label><input type="text" name="facebook" value="{{ old('facebook', $school->facebook) }}" class="form-control-sms @error('facebook') is-invalid @enderror">@error('facebook') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                </div>
            </section>

            <section class="card-sms form-panel">
                <div class="section-heading-saas">
                    <div class="section-icon success"><i class="bi bi-credit-card"></i></div>
                    <div><h3>Plan & Subscription</h3><p>Configure billing and resource limits</p></div>
                </div>

                <div class="form-grid cols-3">
                    <div>
                        <label class="form-label-sms">Subscription Plan <span class="text-danger">*</span></label>
                        <select name="plan_id" class="form-control-sms @error('plan_id') is-invalid @enderror" required>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" @selected(old('plan_id', $school->plan_id) == $plan->id)>{{ $plan->name }} - ${{ number_format($plan->monthly_price) }}/mo</option>
                            @endforeach
                        </select>
                        @error('plan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Billing Cycle</label>
                        <select name="billing_cycle" class="form-control-sms @error('billing_cycle') is-invalid @enderror">
                            <option value="monthly" @selected(old('billing_cycle', $school->billing_cycle) === 'monthly')>Monthly</option>
                            <option value="quarterly" @selected(old('billing_cycle', $school->billing_cycle) === 'quarterly')>Quarterly</option>
                            <option value="annual" @selected(old('billing_cycle', $school->billing_cycle) === 'annual')>Annual (20% off)</option>
                        </select>
                        @error('billing_cycle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms">Trial Period</label>
                        <select name="trial_days" class="form-control-sms @error('trial_days') is-invalid @enderror">
                            @foreach([0 => 'No Trial', 7 => '7 Days', 14 => '14 Days', 30 => '30 Days'] as $days => $label)
                                <option value="{{ $days }}" @selected((string) old('trial_days', $school->trial_days ?? 0) === (string) $days)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('trial_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-grid cols-4 mt-3">
                    <div><label class="form-label-sms">Max Students</label><input type="number" name="max_students" class="form-control-sms @error('max_students') is-invalid @enderror" value="{{ old('max_students', $school->max_students) }}">@error('max_students') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Max Teachers</label><input type="number" name="max_teachers" class="form-control-sms @error('max_teachers') is-invalid @enderror" value="{{ old('max_teachers', $school->max_teachers) }}">@error('max_teachers') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Storage (GB)</label><input type="number" name="storage_gb" class="form-control-sms @error('storage_gb') is-invalid @enderror" value="{{ old('storage_gb', $school->storage_gb) }}">@error('storage_gb') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Custom MRR ($)</label><input type="number" name="custom_mrr" class="form-control-sms @error('custom_mrr') is-invalid @enderror" value="{{ old('custom_mrr', $school->custom_mrr) }}">@error('custom_mrr') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                </div>

                <div class="mt-3">
                    <label class="form-label-sms">Tags / Labels</label>
                    <input type="text" name="tags" value="{{ $tagValue }}" class="form-control-sms @error('tags') is-invalid @enderror">
                    <small class="field-hint">Separate tags with commas.</small>
                    @error('tags') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </section>

            <section class="card-sms form-panel">
                <div class="section-heading-saas">
                    <div class="section-icon purple"><i class="bi bi-toggles"></i></div>
                    <div><h3>Feature Toggles</h3><p>Enable or disable modules for this school</p></div>
                </div>

                @foreach([
                    'sms_notifications' => ['SMS Notifications', 'Allow this school to send SMS alerts to parents', true],
                    'online_fee_collection' => ['Online Fee Collection', 'Enable Stripe / JazzCash payment integration', true],
                    'ai_analytics' => ['AI Analytics', 'AI-powered insights and prediction features', false],
                    'custom_domain' => ['Custom Domain', 'Allow school to use their own domain name', true],
                    'white_label_branding' => ['White-label Branding', 'Remove EduCore branding from school portal', false],
                    'api_access' => ['API Access', 'Generate and use REST API keys', true],
                ] as $key => [$label, $desc, $default])
                    <div class="toggle-row-saas">
                        <div><strong>{{ $label }}</strong><span>{{ $desc }}</span></div>
                        <input type="hidden" name="features[{{ $key }}]" value="0">
                        <label class="toggle-switch"><input type="checkbox" name="features[{{ $key }}]" value="1" @checked(old("features.$key", data_get($featureValues, $key, $default)))><span class="toggle-track"></span></label>
                    </div>
                @endforeach
            </section>

            <section class="card-sms form-panel">
                <div class="section-heading-saas">
                    <div class="section-icon warning"><i class="bi bi-person-badge"></i></div>
                    <div><h3>Admin Account</h3><p>Owner credentials for the school</p></div>
                </div>

                <div class="form-grid">
                    <div><label class="form-label-sms">Admin Name</label><input type="text" name="admin_name" value="{{ old('admin_name', $schoolAdmin->name ?? '') }}" class="form-control-sms @error('admin_name') is-invalid @enderror">@error('admin_name') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Admin Email</label><input type="email" name="admin_email" value="{{ old('admin_email', $schoolAdmin->email ?? '') }}" class="form-control-sms @error('admin_email') is-invalid @enderror">@error('admin_email') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Campus Name <span class="text-danger">*</span></label><input type="text" name="campus_name" x-model="campusName" class="form-control-sms @error('campus_name') is-invalid @enderror" required>@error('campus_name') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Campus Code <span class="text-danger">*</span></label><input type="text" name="campus_code" x-model="campusCode" class="form-control-sms @error('campus_code') is-invalid @enderror" required>@error('campus_code') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div><label class="form-label-sms">Campus Phone</label><input type="text" name="campus_phone" value="{{ old('campus_phone', $mainCampus->phone ?? '') }}" class="form-control-sms @error('campus_phone') is-invalid @enderror">@error('campus_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror</div>
                    <div></div>
                    <div>
                        <label class="form-label-sms">New Password</label>
                        <div class="password-group-sms">
                            <input :type="showPass ? 'text' : 'password'" name="admin_password" x-ref="adminPass" class="form-control-sms @error('admin_password') is-invalid @enderror" placeholder="Leave blank to keep current password">
                            <div class="password-actions-sms">
                                <button type="button" class="password-btn-sms" @click="showPass = !showPass"><i class="bi" :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i></button>
                                <button type="button" class="password-btn-sms" @click="generatePass()"><i class="bi bi-magic"></i></button>
                            </div>
                        </div>
                        @error('admin_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div><label class="form-label-sms">Confirm New Password</label><input :type="showPass ? 'text' : 'password'" name="admin_password_confirmation" x-ref="confirmPass" class="form-control-sms"></div>
                </div>
            </section>
        </main>

        <aside class="add-school-sidebar">
            <section class="sidebar-widget-saas">
                <h4>School Status</h4>
                @foreach(['pending' => ['Trial', 'Setup in progress'], 'active' => ['Active', 'Fully operational'], 'suspended' => ['Suspended', 'Access restricted']] as $value => [$label, $desc])
                    <label class="status-option-saas"><input type="radio" name="status" value="{{ $value }}" @checked(old('status', $school->status) === $value)><span><strong>{{ $label }}</strong><small>{{ $desc }}</small></span></label>
                @endforeach
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </section>

            <section class="sidebar-widget-saas">
                <h4><i class="bi bi-check2-square text-primary"></i> Setup Checklist</h4>
                @foreach(['Basic info filled', 'Contact details added', 'Plan selected', 'Admin account created', 'Logo uploaded', 'Domain configured'] as $index => $item)
                    <label class="checklist-item-saas"><input type="checkbox" @checked($index < 4 || ($index === 4 && $school->logo) || ($index === 5 && $school->primaryDomain))> <span>{{ $item }}</span></label>
                @endforeach
            </section>

            <section class="sidebar-widget-saas">
                <h4>Internal Notes</h4>
                <textarea name="internal_notes" class="form-control-sms form-textarea @error('internal_notes') is-invalid @enderror" style="min-height:90px;">{{ old('internal_notes', $school->internal_notes) }}</textarea>
                <small class="field-hint">Visible to super admins only</small>
                @error('internal_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </section>

            <section class="sidebar-widget-saas">
                <h4>Account Manager</h4>
                <select name="account_manager_id" class="form-control-sms @error('account_manager_id') is-invalid @enderror">
                    <option value="">Unassigned</option>
                    @foreach($accountManagers as $manager)
                        <option value="{{ $manager->id }}" @selected(old('account_manager_id', $school->account_manager_id) == $manager->id)>{{ $manager->name }}</option>
                    @endforeach
                </select>
                <small class="field-hint">Manager receives billing and issue alerts.</small>
                @error('account_manager_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </section>

            <section class="sidebar-widget-saas">
                <h4>Quick Details</h4>
                <div class="quick-detail"><span>Registered</span><strong>{{ $school->created_at->format('M d, Y') }}</strong></div>
                <div class="quick-detail"><span>Last Updated</span><strong>{{ $school->updated_at->diffForHumans() }}</strong></div>
                <div class="quick-detail"><span>Domain</span><strong>{{ $school->primaryDomain->domain ?? 'Not configured' }}</strong></div>
            </section>

            <div class="side-actions">
                <button type="submit" class="btn-primary-sms"><i class="bi bi-check-lg"></i> Save Changes</button>
                <a href="{{ route('super-admin.schools.index') }}" class="btn-outline-sms">Cancel</a>
                <a href="{{ route('super-admin.schools.impersonate', $school) }}" class="btn-ghost-saas">Login as Admin</a>
            </div>
        </aside>
    </div>
</form>
@endsection

@push('styles')
<style>
.add-school-form .schools-head { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:1.25rem; }
.add-school-form .schools-head h1 { margin:0; font-size:1.65rem; }
.add-school-form .schools-head h1 span { color:var(--coral); }
.add-school-form .schools-head p { margin:.25rem 0 0; color:var(--text-mid); }
.form-steps-card { background:white; border:1px solid var(--border); border-radius:16px; padding:1.25rem 1.75rem; margin-bottom:1.25rem; }
.form-steps { display:flex; align-items:center; gap:.8rem; }
.step-item { display:flex; align-items:center; gap:.7rem; color:var(--text-light); min-width:max-content; }
.step-item span { width:30px; height:30px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; background:var(--surface); border:1px solid var(--border); font-weight:800; }
.step-item strong { display:block; color:var(--text-dark); font-size:.85rem; }
.step-item small { display:block; font-size:.73rem; }
.step-item.done span, .step-item.active span { background:var(--coral); color:white; border-color:var(--coral); }
.step-line { height:2px; flex:1; background:var(--border); min-width:36px; }
.step-line.done { background:var(--coral); }
.add-school-layout { display:grid; grid-template-columns:minmax(0, 1fr) 320px; gap:1.25rem; align-items:start; }
.add-school-main { display:grid; gap:1.25rem; min-width:0; }
.form-panel { padding:1.35rem; }
.avatar-upload { display:flex; align-items:center; gap:1rem; padding:1rem; border:1px dashed var(--border); border-radius:14px; background:var(--surface); margin-bottom:1.15rem; }
.avatar-preview { width:64px; height:64px; border-radius:18px; background:var(--coral); color:white; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1.6rem; object-fit:cover; }
.avatar-preview.image { background:white; border:1px solid var(--border); }
.avatar-upload h4 { margin:0 0 .2rem; }
.avatar-upload p { margin:0 0 .65rem; color:var(--text-mid); font-size:.84rem; }
.btn-small { padding:.5rem .7rem; font-size:.8rem; }
.upload-btn { cursor:pointer; }
.upload-btn input { display:none; }
.form-grid.cols-3 { grid-template-columns:repeat(3, minmax(0, 1fr)); }
.form-grid.cols-4 { grid-template-columns:repeat(4, minmax(0, 1fr)); }
.field-hint { display:block; margin-top:.35rem; color:var(--text-light); font-size:.74rem; }
.input-prefix-wrap, .input-suffix-wrap, .input-icon-left { position:relative; }
.input-prefix-wrap span, .input-suffix-wrap span, .input-icon-left i { position:absolute; top:50%; transform:translateY(-50%); color:var(--text-light); font-size:.86rem; pointer-events:none; }
.input-prefix-wrap span { left:.85rem; }
.input-prefix-wrap .form-control-sms { padding-left:3.4rem; }
.input-prefix-wrap.wide .form-control-sms { padding-left:4.8rem; }
.input-suffix-wrap span { right:.85rem; }
.input-suffix-wrap .form-control-sms { padding-right:7.5rem; }
.input-icon-left i { left:.85rem; }
.input-icon-left .form-control-sms { padding-left:2.5rem; }
.form-textarea { min-height:96px; resize:vertical; }
.toggle-row-saas { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem 0; border-top:1px solid var(--border); }
.toggle-row-saas:first-of-type { border-top:0; }
.toggle-row-saas strong { display:block; }
.toggle-row-saas span { display:block; color:var(--text-light); font-size:.82rem; margin-top:.15rem; }
.toggle-switch { position:relative; display:inline-flex; width:44px; height:24px; flex:0 0 auto; }
.toggle-switch input { opacity:0; width:0; height:0; }
.toggle-track { position:absolute; inset:0; border-radius:999px; background:#ddd8d0; transition:.2s; }
.toggle-track:before { content:""; position:absolute; width:18px; height:18px; left:3px; top:3px; border-radius:999px; background:white; transition:.2s; box-shadow:0 1px 4px rgba(0,0,0,.2); }
.toggle-switch input:checked + .toggle-track { background:var(--coral); }
.toggle-switch input:checked + .toggle-track:before { transform:translateX(20px); }
.add-school-sidebar { display:grid; gap:1rem; position:sticky; top:92px; }
.sidebar-widget-saas { background:white; border:1px solid var(--border); border-radius:16px; padding:1rem; }
.sidebar-widget-saas h4 { margin:0 0 .85rem; font-size:.95rem; }
.status-option-saas { display:flex; gap:.65rem; padding:.75rem; border:1px solid var(--border); border-radius:12px; margin-bottom:.55rem; cursor:pointer; }
.status-option-saas:has(input:checked) { border-color:var(--coral-border); background:var(--coral-pale); }
.status-option-saas input { margin-top:.18rem; accent-color:var(--coral); }
.status-option-saas strong, .status-option-saas small { display:block; }
.status-option-saas small { color:var(--text-light); font-size:.76rem; margin-top:.15rem; }
.checklist-item-saas { display:flex; align-items:center; gap:.55rem; padding:.45rem 0; color:var(--text-mid); font-size:.86rem; }
.checklist-item-saas input { accent-color:var(--coral); }
.quick-detail { display:flex; justify-content:space-between; gap:.75rem; padding:.55rem 0; border-top:1px solid var(--border); font-size:.82rem; }
.quick-detail:first-of-type { border-top:0; }
.quick-detail span { color:var(--text-light); }
.quick-detail strong { text-align:right; overflow-wrap:anywhere; }
.side-actions { display:grid; gap:.55rem; }
.side-actions .btn-primary-sms, .side-actions .btn-outline-sms, .btn-ghost-saas { justify-content:center; width:100%; text-align:center; }
.btn-ghost-saas { border:0; background:transparent; color:var(--coral); font-weight:800; padding:.75rem; border-radius:10px; }
.password-group-sms { position:relative; }
.password-actions-sms { position:absolute; right:.55rem; top:50%; transform:translateY(-50%); display:flex; gap:.25rem; }
.password-btn-sms { border:0; background:transparent; color:var(--text-light); padding:.35rem; cursor:pointer; }
.password-group-sms .form-control-sms { padding-right:5rem; }
@media (max-width:1200px) {
    .add-school-layout { grid-template-columns:1fr; }
    .add-school-sidebar { position:static; grid-template-columns:repeat(2, minmax(0, 1fr)); }
    .side-actions { grid-column:1 / -1; }
}
@media (max-width:900px) {
    .add-school-form .schools-head, .form-steps { flex-direction:column; align-items:stretch; }
    .step-line { display:none; }
    .form-grid.cols-3, .form-grid.cols-4, .add-school-sidebar { grid-template-columns:1fr; }
}
</style>
@endpush
