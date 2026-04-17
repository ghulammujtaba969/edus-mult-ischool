<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Student;
use App\Services\Contracts\AttendanceServiceInterface;
use App\Services\Contracts\FeeServiceInterface;
use App\Services\Contracts\ReportServiceInterface;

class ReportService implements ReportServiceInterface
{
    public function __construct(
        private readonly AttendanceServiceInterface $attendanceService,
        private readonly FeeServiceInterface $feeService,
    ) {
    }

    public function dashboardMetrics(): array
    {
        return [
            'students' => Student::query()->count(),
            'attendance' => $this->attendanceService->todayAttendanceSummary(),
            'fees' => $this->feeService->monthlyCollectionSummary(),
            'staff_count' => Employee::query()->where('status', 'active')->count(),
        ];
    }
}
