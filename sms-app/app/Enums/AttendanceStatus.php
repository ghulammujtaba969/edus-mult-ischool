<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case LEAVE = 'leave';
    case HOLIDAY = 'holiday';
    case LATE = 'late';
    case HALF_DAY = 'half_day';
}
