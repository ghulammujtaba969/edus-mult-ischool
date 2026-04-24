@extends('layouts.app')

@section('title', 'Complaints | EduCore SMS')
@section('page_title', 'Front Office - Complaints')
@section('breadcrumb', '/ Front Office / Complaints')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.front-office-complaints.create') }}"><i class="bi bi-megaphone-fill"></i> Log Complaint</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>By</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($complaints as $complaint)
                <tr>
                    <td style="font-weight:700;">{{ $complaint->complaint_by }}</td>
                    <td class="mono">{{ $complaint->phone }}</td>
                    <td class="mono">{{ $complaint->date->format('M d, Y') }}</td>
                    <td>{{ $complaint->assigned_to }}</td>
                    <td>
                        <span class="status-pill {{ $complaint->status === 'pending' ? 'pill-inactive' : ($complaint->status === 'resolved' ? 'pill-active' : 'pill-warning') }}">
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </td>
                    <td>
                        @if($complaint->status !== 'resolved')
                            <button class="btn-outline-sms" onclick="document.getElementById('resolve-modal-{{ $complaint->id }}').style.display='flex'"><i class="bi bi-check-circle"></i> Resolve</button>
                            
                            <!-- Resolve Modal -->
                            <div id="resolve-modal-{{ $complaint->id }}" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;">
                                <div class="data-card" style="width:100%;max-width:400px;margin:0 1rem;">
                                    <div class="card-title">Resolve Complaint</div>
                                    <form action="{{ route('admin.front-office-complaints.update', $complaint) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="resolved">
                                        <div style="margin-bottom:1.5rem;">
                                            <label class="form-label-sms">Action Taken</label>
                                            <textarea class="form-control-sms" name="action_taken" rows="3" required></textarea>
                                        </div>
                                        <div style="display:flex;gap:1rem;">
                                            <button class="btn-primary-sms" type="submit" style="flex:1;">Mark Resolved</button>
                                            <button class="btn-outline-sms" type="button" onclick="document.getElementById('resolve-modal-{{ $complaint->id }}').style.display='none'" style="flex:1;justify-content:center;">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No complaints found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
