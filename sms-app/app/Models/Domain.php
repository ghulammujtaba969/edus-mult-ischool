<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'domain',
        'type',
        'is_verified',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
