<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdmissionInquiry extends Model
{
    use HasFactory, BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'student_name',
        'guardian_name',
        'phone',
        'email',
        'school_class_id',
        'status',
        'address',
        'remarks',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
