<?php

namespace App\Services;

use App\Enums\AttendanceStatus;
use App\Models\StudentAcademicRecord;
use App\Models\StudentAttendance;
use App\Services\Contracts\AttendanceServiceInterface;
use Carbon\Carbon;

class AttendanceService implements AttendanceServiceInterface
{
    public function todayAttendanceSummary(): array
    {
        $today = Carbon::today()->toDateString();
        $studentCount = StudentAcademicRecord::query()->where('is_current', true)->count();
        $presentCount = StudentAttendance::query()
            ->whereDate('attendance_date', $today)
            ->whereIn('status', [AttendanceStatus::PRESENT, AttendanceStatus::LATE, AttendanceStatus::HALF_DAY])
            ->count();

        return [
            'student_count' => $studentCount,
            'present_count' => $presentCount,
            'percentage' => $studentCount > 0 ? round(($presentCount / $studentCount) * 100, 1) : 0,
        ];
    }
}
