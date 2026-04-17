<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentParent extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'student_id',
        'father_name',
        'father_cnic',
        'father_phone',
        'father_occupation',
        'mother_name',
        'mother_phone',
        'guardian_name',
        'guardian_phone',
        'emergency_contact',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
