@extends('layouts.app')

@section('title', 'Notifications | EduCore SMS')
@section('page_title', 'Notifications')
@section('breadcrumb', '/ Main / Notifications')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.notifications.create') }}"><i class="bi bi-send-fill"></i> Send Notification</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Type</th>
                <th>Title</th>
                <th>Target</th>
                <th>Sent At</th>
            </tr>
            </thead>
            <tbody>
            @forelse($notifications as $notification)
                <tr>
                    <td>
                        <span class="status-pill {{ $notification->type === 'announcement' ? 'pill-active' : 'pill-inactive' }}">
                            {{ ucfirst($notification->type) }}
                        </span>
                    </td>
                    <td style="font-weight:700;">{{ $notification->title }}</td>
                    <td>{{ $notification->target_role ?? 'All' }}</td>
                    <td class="mono">{{ $notification->sent_at->format('M d, Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-light);">No notifications sent yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="data-footer">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
