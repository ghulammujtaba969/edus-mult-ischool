@extends('layouts.app')

@section('title', 'Admission Enquiries | EduCore SMS')
@section('page_title', 'Front Office - Enquiries')
@section('breadcrumb', '/ Front Office / Enquiries')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.front-office-enquiries.create') }}"><i class="bi bi-plus-lg"></i> New Enquiry</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Source</th>
                <th>Follow Up</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($enquiries as $enquiry)
                <tr>
                    <td style="font-weight:700;">{{ $enquiry->name }}</td>
                    <td class="mono">{{ $enquiry->phone }}</td>
                    <td><span class="nav-badge">{{ $enquiry->source }}</span></td>
                    <td class="mono">{{ $enquiry->next_follow_up_date?->format('M d, Y') ?? 'N/A' }}</td>
                    <td>
                        <span class="status-pill {{ $enquiry->status === 'active' ? 'pill-warning' : ($enquiry->status === 'won' ? 'pill-active' : 'pill-inactive') }}">
                            {{ ucfirst($enquiry->status) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn-outline-sms" onclick="alert('{{ $enquiry->description }}')"><i class="bi bi-chat-text"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No enquiries found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
