@extends('layouts.app')

@section('title', 'Platform Settings | SaaS Admin')
@section('page_title', 'Platform Settings')
@section('breadcrumb', '/ Super Admin / Settings')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">General Settings</div>
        <form action="{{ route('super-admin.settings.update') }}" method="POST">
            @csrf
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms">Platform Name</label>
                <input type="text" name="platform_name" class="form-control-sms" value="{{ $settings['platform_name'] ?? 'EduCore SaaS' }}">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms">Support Email</label>
                <input type="email" name="support_email" class="form-control-sms" value="{{ $settings['support_email'] ?? 'support@educore.test' }}">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms">Max Trial Days</label>
                <input type="number" name="trial_days" class="form-control-sms" value="{{ $settings['trial_days'] ?? 14 }}">
            </div>

            <div style="margin-bottom:2rem;">
                <label style="display:flex;gap:.5rem;align-items:center;cursor:pointer;">
                    <input type="checkbox" name="maintenance_mode" value="1" @checked(isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1')>
                    <span>Enable Maintenance Mode</span>
                </label>
            </div>

            <button type="submit" class="btn-primary-sms"><i class="bi bi-save"></i> Save Settings</button>
        </form>
    </div>
@endsection
