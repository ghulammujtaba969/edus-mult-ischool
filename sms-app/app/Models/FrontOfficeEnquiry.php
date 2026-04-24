<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FrontOfficeEnquiry extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'name',
        'phone',
        'email',
        'address',
        'description',
        'note',
        'date',
        'next_follow_up_date',
        'source',
        'status',
        'class_id',
    ];

    protected $casts = [
        'date' => 'date',
        'next_follow_up_date' => 'date',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
