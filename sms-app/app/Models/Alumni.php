<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumni extends Model
{
    use HasFactory, BelongsToCampus;

    protected $table = 'alumnis';

    protected $fillable = [
        'campus_id',
        'student_id',
        'name',
        'email',
        'phone',
        'graduation_year',
        'current_occupation',
        'current_organization',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
