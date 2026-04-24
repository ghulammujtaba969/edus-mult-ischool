<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OnlineExam extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'exam_title',
        'exam_from',
        'exam_to',
        'duration_minutes',
        'minimum_percentage',
        'is_active',
        'publish_result',
    ];

    protected $casts = [
        'exam_from' => 'datetime',
        'exam_to' => 'datetime',
        'is_active' => 'boolean',
        'publish_result' => 'boolean',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(OnlineExamQuestion::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(OnlineExamAttempt::class);
    }
}
