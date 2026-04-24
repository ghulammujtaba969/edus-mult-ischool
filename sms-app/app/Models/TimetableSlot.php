<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimetableSlot extends Model
{
    use HasFactory, BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'day',
        'period_no',
        'start_time',
        'end_time',
        'is_break',
    ];

    public function entries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class);
    }
}
