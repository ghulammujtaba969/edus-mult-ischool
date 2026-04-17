<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAttendance extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $table = 'student_attendance';

    protected $fillable = [
        'campus_id',
        'student_id',
        'section_id',
        'attendance_date',
        'status',
        'method',
        'marked_by',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'status' => AttendanceStatus::class,
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
