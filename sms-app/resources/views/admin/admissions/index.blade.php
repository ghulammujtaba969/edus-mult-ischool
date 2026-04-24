@extends('layouts.app')

@section('title', 'Admission Inquiries | EduCore SMS')
@section('page_title', 'Online Admission Inquiries')
@section('breadcrumb', '/ Students / Admissions')

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Student Name</th>
                <th>Guardian</th>
                <th>Class</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($inquiries as $inquiry)
                <tr>
                    <td class="mono">{{ $inquiry->created_at->format('M d, Y') }}</td>
                    <td style="font-weight:700;">{{ $inquiry->student_name }}</td>
                    <td>{{ $inquiry->guardian_name }}</td>
                    <td>{{ $inquiry->schoolClass->name }}</td>
                    <td class="mono">{{ $inquiry->phone }}</td>
                    <td>
                        @if($inquiry->status == 'pending')
                            <span class="badge-sms badge-warning-sms">Pending</span>
                        @elseif($inquiry->status == 'approved')
                            <span class="badge-sms badge-success-sms">Approved</span>
                        @else
                            <span class="badge-sms badge-danger-sms">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.admission-inquiries.show', $inquiry) }}"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('admin.admission-inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-sms text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-light);">No admission inquiries found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
