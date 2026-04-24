@extends('layouts.app')

@section('title', 'System Settings | EduCore SMS')
@section('page_title', 'System Settings')
@section('breadcrumb', '/ Settings')

@section('content')
    <div x-data="{ tab: 'general' }" class="data-card" style="max-width:900px;margin:0 auto;padding:0;">
        <div style="display:flex;border-bottom:1px solid var(--border-color);background:var(--bg-light);border-radius:12px 12px 0 0;">
            <button @click="tab = 'general'" :class="tab === 'general' ? 'tab-active' : 'tab-inactive'">General Settings</button>
            <button @click="tab = 'sms'" :class="tab === 'sms' ? 'tab-active' : 'tab-inactive'">SMS Gateway</button>
            <button @click="tab = 'email'" :class="tab === 'email' ? 'tab-active' : 'tab-inactive'">Email Gateway</button>
        </div>

        <div style="padding:2rem;">
            <!-- General Settings -->
            <div x-show="tab === 'general'">
                <form action="{{ route('admin.settings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="group" value="general">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                        <div>
                            <label class="form-label-sms">School Name</label>
                            <input class="form-control-sms" type="text" name="settings[school_name]" value="{{ $settings->get('general')?->where('key', 'school_name')->first()?->value }}" placeholder="e.g. EduCore International">
                        </div>
                        <div>
                            <label class="form-label-sms">Contact Email</label>
                            <input class="form-control-sms" type="email" name="settings[contact_email]" value="{{ $settings->get('general')?->where('key', 'contact_email')->first()?->value }}">
                        </div>
                    </div>
                    <div style="margin-bottom:2rem;">
                        <label class="form-label-sms">Address</label>
                        <textarea class="form-control-sms" name="settings[address]" rows="3">{{ $settings->get('general')?->where('key', 'address')->first()?->value }}</textarea>
                    </div>
                    <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save General Settings</button>
                </form>
            </div>

            <!-- SMS Gateway -->
            <div x-show="tab === 'sms'">
                <form action="{{ route('admin.settings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="group" value="sms">
                    <div style="margin-bottom:1.5rem;">
                        <label class="form-label-sms">SMS Provider</label>
                        <select class="form-control-sms" name="settings[sms_provider]">
                            <option value="twilio" @selected($settings->get('sms')?->where('key', 'sms_provider')->first()?->value == 'twilio')>Twilio</option>
                            <option value="nexmo" @selected($settings->get('sms')?->where('key', 'sms_provider')->first()?->value == 'nexmo')>Nexmo</option>
                        </select>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                        <div>
                            <label class="form-label-sms">API Key / Account SID</label>
                            <input class="form-control-sms" type="text" name="settings[sms_api_key]" value="{{ $settings->get('sms')?->where('key', 'sms_api_key')->first()?->value }}">
                        </div>
                        <div>
                            <label class="form-label-sms">API Secret / Auth Token</label>
                            <input class="form-control-sms" type="password" name="settings[sms_api_secret]" value="{{ $settings->get('sms')?->where('key', 'sms_api_secret')->first()?->value }}">
                        </div>
                    </div>
                    <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save SMS Settings</button>
                </form>
            </div>

            <!-- Email Gateway -->
            <div x-show="tab === 'email'">
                <form action="{{ route('admin.settings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="group" value="email">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                        <div>
                            <label class="form-label-sms">SMTP Host</label>
                            <input class="form-control-sms" type="text" name="settings[smtp_host]" value="{{ $settings->get('email')?->where('key', 'smtp_host')->first()?->value }}">
                        </div>
                        <div>
                            <label class="form-label-sms">SMTP Port</label>
                            <input class="form-control-sms" type="text" name="settings[smtp_port]" value="{{ $settings->get('email')?->where('key', 'smtp_port')->first()?->value }}">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
                        <div>
                            <label class="form-label-sms">SMTP Username</label>
                            <input class="form-control-sms" type="text" name="settings[smtp_user]" value="{{ $settings->get('email')?->where('key', 'smtp_user')->first()?->value }}">
                        </div>
                        <div>
                            <label class="form-label-sms">SMTP Password</label>
                            <input class="form-control-sms" type="password" name="settings[smtp_pass]" value="{{ $settings->get('email')?->where('key', 'smtp_pass')->first()?->value }}">
                        </div>
                    </div>
                    <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Email Settings</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .tab-active {
            padding: 1rem 2rem;
            border: none;
            background: white;
            color: var(--primary-color);
            font-weight: 700;
            cursor: pointer;
            border-bottom: 2px solid var(--primary-color);
        }
        .tab-inactive {
            padding: 1rem 2rem;
            border: none;
            background: transparent;
            color: var(--charcoal-muted);
            font-weight: 600;
            cursor: pointer;
        }
        .tab-inactive:hover {
            color: var(--primary-color);
        }
    </style>
@endsection
