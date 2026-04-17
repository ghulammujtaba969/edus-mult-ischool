@extends('layouts.app')

@section('title', ($student->user?->name ?? 'Student') . ' | EduCore SMS')
@section('page_title', 'Student Profile')
@section('breadcrumb', '/ ' . ($student->user?->name ?? 'Student'))

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.students.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
    <button class="btn-outline-sms" type="button"><i class="bi bi-printer"></i> Print Card</button>
    <a class="btn-primary-sms" href="{{ route('admin.students.edit', $student) }}"><i class="bi bi-pencil"></i> Edit Profile</a>
@endsection

@section('content')
    <div class="profile-grid" x-data="{ tab: 'info' }">
        <div>
            <div class="profile-card">
                <div class="profile-hero">
                    <div class="profile-avatar">{{ str($student->user?->name ?? 'ST')->substr(0, 2)->upper() }}</div>
                </div>
                <div class="profile-name">{{ $student->user?->name }}</div>
                <div class="profile-class">{{ $student->currentAcademicRecord?->schoolClass?->name }} - Section {{ $student->currentAcademicRecord?->section?->name }}</div>
                <div class="profile-reg">{{ $student->registration_no }}</div>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin:1rem 0;">
                    <span class="status-pill pill-active">{{ ucfirst($student->status->value) }}</span>
                    <span class="status-pill {{ $student->gender === 'Male' ? 'pill-male' : 'pill-female' }}">{{ $student->gender }}</span>
                    <span class="status-pill pill-partial">Roll #{{ $student->currentAcademicRecord?->roll_no }}</span>
                </div>
                <div class="profile-info-grid">
                    <div class="info-field"><label>Date of Birth</label><span>{{ $student->date_of_birth->format('d M, Y') }}</span></div>
                    <div class="info-field"><label>Blood Group</label><span>{{ $student->blood_group }}</span></div>
                    <div class="info-field"><label>B-Form No.</label><span class="mono">{{ $student->b_form_no }}</span></div>
                    <div class="info-field"><label>Enrolled</label><span>{{ $student->enrollment_date->format('M Y') }}</span></div>
                </div>
                <div class="contact-row"><i class="bi bi-telephone-fill"></i><span>{{ $student->guardian?->father_phone }}</span></div>
                <div class="contact-row"><i class="bi bi-envelope-fill"></i><span>{{ $student->email }}</span></div>
                <div class="contact-row"><i class="bi bi-geo-alt-fill"></i><span>{{ $student->address }}</span></div>
            </div>

            @php($latestInvoice = $recentInvoices->first())
            <div class="card-sms" style="margin-top:1rem;">
                <div class="card-title">Fee Status</div>
                @if($latestInvoice)
                    <div class="summary-pill {{ $latestInvoice->status->value === 'paid' ? '' : 'alert' }}">
                        <span class="status-pill {{ $latestInvoice->status->value === 'paid' ? 'pill-paid' : ($latestInvoice->status->value === 'partial' ? 'pill-partial' : 'pill-unpaid') }}">{{ ucfirst($latestInvoice->status->value) }}</span>
                        <strong>PKR {{ number_format($latestInvoice->net_amount) }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-sms">
            <div class="tab-nav">
                <button class="tab-btn" :class="{ 'active': tab === 'info' }" @click="tab = 'info'">Personal Info</button>
                <button class="tab-btn" :class="{ 'active': tab === 'results' }" @click="tab = 'results'">Results</button>
                <button class="tab-btn" :class="{ 'active': tab === 'attendance' }" @click="tab = 'attendance'">Attendance</button>
                <button class="tab-btn" :class="{ 'active': tab === 'fees' }" @click="tab = 'fees'">Fee History</button>
            </div>

            <div x-show="tab === 'info'">
                <h3>Parent / Guardian Information</h3>
                <div class="info-grid-2">
                    <div class="info-field"><label>Father's Name</label><span>{{ $student->guardian?->father_name }}</span></div>
                    <div class="info-field"><label>Father's CNIC</label><span class="mono">{{ $student->guardian?->father_cnic }}</span></div>
                    <div class="info-field"><label>Father's Occupation</label><span>{{ $student->guardian?->father_occupation }}</span></div>
                    <div class="info-field"><label>Emergency Contact</label><span>{{ $student->guardian?->emergency_contact }}</span></div>
                    <div class="info-field"><label>Mother's Name</label><span>{{ $student->guardian?->mother_name }}</span></div>
                    <div class="info-field"><label>Mother's Phone</label><span>{{ $student->guardian?->mother_phone }}</span></div>
                </div>

                <h3>Academic Information</h3>
                <div class="info-grid-3">
                    <div class="info-field"><label>Current Class</label><span>{{ $student->currentAcademicRecord?->schoolClass?->name }}</span></div>
                    <div class="info-field"><label>Section</label><span>{{ $student->currentAcademicRecord?->section?->name }}</span></div>
                    <div class="info-field"><label>Roll Number</label><span>{{ $student->currentAcademicRecord?->roll_no }}</span></div>
                </div>
            </div>

            <div x-show="tab === 'results'" x-cloak>
                <div class="summary-pill"><strong>{{ $resultSummary['percentage'] }}%</strong> overall academic average</div>
                @foreach($resultSummary['records'] as $mark)
                    <div class="result-subject-row">
                        <div style="width:140px;">{{ $mark->subject?->name }}</div>
                        <div class="mono">{{ $mark->obtained_marks }} / {{ $mark->total_marks }}</div>
                        <div class="bar-track"><div class="bar-fill" style="width: {{ round(($mark->obtained_marks / max($mark->total_marks, 1)) * 100) }}%;"></div></div>
                    </div>
                @endforeach
            </div>

            <div x-show="tab === 'attendance'" x-cloak>
                <div class="summary-row">
                    <div class="summary-pill"><strong>{{ $attendanceSummary['overall'] }}%</strong> overall</div>
                    <div class="summary-pill"><strong>{{ $attendanceSummary['present'] }}</strong> present</div>
                    <div class="summary-pill"><strong>{{ $attendanceSummary['absent'] }}</strong> absent</div>
                    <div class="summary-pill"><strong>{{ $attendanceSummary['leave'] }}</strong> leave</div>
                </div>
                <table class="sms-table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Method</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($student->attendanceRecords->sortByDesc('attendance_date')->take(12) as $attendance)
                        <tr>
                            <td>{{ $attendance->attendance_date->format('M j, Y') }}</td>
                            <td><span class="status-pill {{ in_array($attendance->status->value, ['present', 'late', 'half_day']) ? 'pill-paid' : ($attendance->status->value === 'leave' ? 'pill-partial' : 'pill-unpaid') }}">{{ ucfirst(str_replace('_', ' ', $attendance->status->value)) }}</span></td>
                            <td>{{ ucfirst($attendance->method) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'fees'" x-cloak>
                <table class="sms-table">
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Fee Type</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recentInvoices as $invoice)
                        <tr>
                            <td>{{ $invoice->billing_month->format('M Y') }}</td>
                            <td>{{ $invoice->feeType?->name }}</td>
                            <td class="mono">PKR {{ number_format($invoice->net_amount) }}</td>
                            <td class="mono">PKR {{ number_format($invoice->paid_amount) }}</td>
                            <td><span class="status-pill {{ $invoice->status->value === 'paid' ? 'pill-paid' : ($invoice->status->value === 'partial' ? 'pill-partial' : 'pill-unpaid') }}">{{ ucfirst($invoice->status->value) }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
