<?php

namespace App\Services\Contracts;

interface AttendanceServiceInterface
{
    public function todayAttendanceSummary(): array;
}
