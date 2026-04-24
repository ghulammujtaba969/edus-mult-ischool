@extends('layouts.app')

@section('title', 'View Inquiry | EduCore SMS')
@section('page_title', 'Admission Inquiry Details')
@section('breadcrumb', '/ Students / Admissions / View')

@section('content')
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:2rem;">
        <!-- Inquiry Details -->
        <div class="data-card">
            <div class="card-title">Inquiry Information</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-bottom:2rem;">
                <div>
                    <div style="color:var(--text-light);font-size:.8rem;">Student Name</div>
                    <div style="font-weight:700;font-size:1.1rem;">{{ $admissionInquiry->student_name }}</div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.8rem;">Applying for Class</div>
                    <div style="font-weight:700;font-size:1.1rem;">{{ $admissionInquiry->schoolClass->name }}</div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.8rem;">Guardian Name</div>
                    <div style="font-weight:700;">{{ $admissionInquiry->guardian_name }}</div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.8rem;">Phone Number</div>
                    <div style="font-weight:700;" class="mono">{{ $admissionInquiry->phone }}</div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.8rem;">Email Address</div>
                    <div style="font-weight:700;">{{ $admissionInquiry->email ?? '--' }}</div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.8rem;">Submission Date</div>
                    <div style="font-weight:700;">{{ $admissionInquiry->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
            <div style="margin-bottom:1rem;">
                <div style="color:var(--text-light);font-size:.8rem;">Address</div>
                <div style="font-weight:500;">{{ $admissionInquiry->address ?? 'Not provided' }}</div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="data-card">
            <div class="card-title">Update Status</div>
            <form action="{{ route('admin.admission-inquiries.update', $admissionInquiry) }}" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom:1.5rem;">
                    <label class="form-label-sms">Current Status</label>
                    <select name="status" class="form-control-sms" required>
                        <option value="pending" @selected($admissionInquiry->status == 'pending')>Pending</option>
                        <option value="approved" @selected($admissionInquiry->status == 'approved')>Approved</option>
                        <option value="rejected" @selected($admissionInquiry->status == 'rejected')>Rejected</option>
                    </select>
                </div>
                <div style="margin-bottom:2rem;">
                    <label class="form-label-sms">Internal Remarks</label>
                    <textarea name="remarks" class="form-control-sms" rows="4" placeholder="Enter follow-up notes...">{{ $admissionInquiry->remarks }}</textarea>
                </div>
                <button type="submit" class="btn-primary-sms w-full"><i class="bi bi-save"></i> Update Inquiry</button>
            </form>
            
            @if($admissionInquiry->status == 'approved')
                <div style="margin-top:1.5rem;padding:1rem;background:var(--bg-light);border-radius:8px;text-align:center;">
                    <p style="font-size:.85rem;margin-bottom:1rem;">Inquiry is approved. You can now enroll this student.</p>
                    <a href="{{ route('admin.students.create') }}?name={{ urlencode($admissionInquiry->student_name) }}&parent={{ urlencode($admissionInquiry->guardian_name) }}&phone={{ urlencode($admissionInquiry->phone) }}" class="btn-outline-sms w-full">
                        <i class="bi bi-person-plus"></i> Proceed to Enrollment
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
