@extends('layouts.app')

@section('title', 'Book Issues | EduCore SMS')
@section('page_title', 'Issue & Return')
@section('breadcrumb', '/ Library / Issues')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.library-issues.create') }}"><i class="bi bi-journal-plus"></i> Issue Book</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Book Title</th>
                <th>Member</th>
                <th>Issue Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($issues as $issue)
                <tr>
                    <td style="font-weight:700;">{{ $issue->book->title }}</td>
                    <td>{{ $issue->member->user->name }}</td>
                    <td class="mono">{{ $issue->issue_date->format('M d, Y') }}</td>
                    <td class="mono" style="color:{{ $issue->due_date->isPast() && $issue->status === 'issued' ? 'var(--danger)' : 'inherit' }};">
                        {{ $issue->due_date->format('M d, Y') }}
                    </td>
                    <td>
                        <span class="status-pill {{ $issue->status === 'issued' ? 'pill-warning' : 'pill-active' }}">
                            {{ ucfirst($issue->status) }}
                        </span>
                    </td>
                    <td>
                        @if($issue->status === 'issued')
                            <button class="btn-outline-sms" onclick="document.getElementById('return-modal-{{ $issue->id }}').style.display='flex'"><i class="bi bi-arrow-return-left"></i> Return</button>
                            
                            <!-- Return Modal -->
                            <div id="return-modal-{{ $issue->id }}" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;">
                                <div class="data-card" style="width:100%;max-width:400px;margin:0 1rem;">
                                    <div class="card-title">Return Book</div>
                                    <form action="{{ route('admin.library-issues.update', $issue) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="returned">
                                        <div style="margin-bottom:1.5rem;">
                                            <label class="form-label-sms">Return Date</label>
                                            <input class="form-control-sms" type="date" name="return_date" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div style="margin-bottom:1.5rem;">
                                            <label class="form-label-sms">Fine Amount (if any)</label>
                                            <input class="form-control-sms" type="number" name="fine_amount" value="0" step="0.01">
                                        </div>
                                        <div style="display:flex;gap:1rem;">
                                            <button class="btn-primary-sms" type="submit" style="flex:1;">Return Book</button>
                                            <button class="btn-outline-sms" type="button" onclick="document.getElementById('return-modal-{{ $issue->id }}').style.display='none'" style="flex:1;justify-content:center;">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No issues recorded.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
