@extends('layouts.app')

@section('title', 'Dashboard | EduCore SMS')
@section('page_title', 'Dashboard')
@section('breadcrumb', '/ Overview')

@section('content')
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Total Students</div>
            <div class="kpi-value">{{ number_format($metrics['students']) }}</div>
            <div class="delta-up">Campus wide enrollment</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Today's Attendance</div>
            <div class="kpi-value">{{ $metrics['attendance']['percentage'] }}%</div>
            <div class="delta-up">{{ $metrics['attendance']['present_count'] }} present today</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Fee Collected</div>
            <div class="kpi-value">PKR {{ number_format($metrics['fees']['collected']) }}</div>
            <div class="delta-down">PKR {{ number_format($metrics['fees']['pending']) }} pending</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Active Staff</div>
            <div class="kpi-value">{{ number_format($metrics['staff_count']) }}</div>
            <div class="muted">{{ $activeCampus?->name ?? 'Campus not selected' }}</div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div>
            <div class="card-sms">
                <div class="card-title">Collection by Class</div>
                @foreach($collectionByClass as $row)
                    <div class="bar-row">
                        <div style="width:90px;">{{ $row['name'] }}</div>
                        <div class="bar-track"><div class="bar-fill" style="width: {{ $row['percentage'] }}%;"></div></div>
                        <div style="width:48px;text-align:right;font-weight:700;">{{ $row['percentage'] }}%</div>
                    </div>
                @endforeach
            </div>

            <div class="card-sms" style="margin-top:1.25rem;">
                <div class="card-title">Recent Fee Payments <span class="card-title-action">Live seeded data</span></div>
                <table class="sms-table">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recentPayments as $payment)
                        <tr>
                            <td>{{ $payment->student?->user?->name ?? 'Student' }}</td>
                            <td>{{ $payment->student?->currentAcademicRecord?->schoolClass?->name ?? 'N/A' }}</td>
                            <td class="mono">PKR {{ number_format($payment->amount_paid) }}</td>
                            <td>{{ $payment->payment_date?->format('M j, Y') }}</td>
                            <td><span class="status-pill pill-paid">Paid</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-sms">
            <div class="card-title">Recent Activity</div>
            @foreach($activities as $activity)
                <div class="activity-item">
                    <div class="activity-icon tone-{{ $activity->tone }}"><i class="bi {{ $activity->icon }}"></i></div>
                    <div>
                        <div style="font-weight:700;">{{ $activity->title }}</div>
                        <div class="muted">{{ $activity->description }}</div>
                        <div class="muted" style="font-size:.8rem;">{{ $activity->logged_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
