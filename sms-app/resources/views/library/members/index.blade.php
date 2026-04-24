@extends('layouts.app')

@section('title', 'Library Members | EduCore SMS')
@section('page_title', 'Library Members')
@section('breadcrumb', '/ Library / Members')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.library-members.create') }}"><i class="bi bi-person-plus-fill"></i> Add Member</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Member Name</th>
                <th>Card No</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($members as $member)
                <tr>
                    <td style="font-weight:700;">{{ $member->user->name }}</td>
                    <td class="mono">{{ $member->library_card_no }}</td>
                    <td><span class="nav-badge">{{ ucfirst($member->user->role->value) }}</span></td>
                    <td>
                        <span class="status-pill {{ $member->status === 'active' ? 'pill-active' : 'pill-inactive' }}">
                            {{ ucfirst($member->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.library-members.destroy', $member) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No members registered.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
