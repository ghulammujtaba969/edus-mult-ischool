<?php

namespace App\Models;

use App\Enums\StudentStatus;
use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'user_id',
        'registration_no',
        'b_form_no',
        'date_of_birth',
        'gender',
        'blood_group',
        'religion',
        'nationality',
        'enrollment_date',
        'status',
        'photo_path',
        'email',
        'address',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
        'status' => StudentStatus::class,
    ];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guardian(): HasOne
    {
        return $this->hasOne(StudentParent::class);
    }

    public function academicRecords(): HasMany
    {
        return $this->hasMany(StudentAcademicRecord::class);
    }

    public function currentAcademicRecord(): HasOne
    {
        return $this->hasOne(StudentAcademicRecord::class)->where('is_current', true)->latestOfMany();
    }

    public function feeInvoices(): HasMany
    {
        return $this->hasMany(FeeInvoice::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }
}
