@extends('layouts.app')

@section('title', 'Certificate Templates | EduCore SMS')
@section('page_title', 'Certificate Templates')
@section('breadcrumb', '/ Admin / Certificates')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.certificate-templates.create') }}"><i class="bi bi-plus-lg"></i> Create Template</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Template Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($templates as $tpl)
                <tr>
                    <td style="font-weight:700;">{{ $tpl->name }}</td>
                    <td>{{ ucfirst($tpl->certificate_type) }}</td>
                    <td>
                        <span class="status-pill {{ $tpl->is_active ? 'pill-active' : 'pill-inactive' }}">
                            {{ $tpl->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <button class="btn-outline-sms" title="Preview"><i class="bi bi-eye"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-light);">No certificate templates found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
