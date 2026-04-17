<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'user_id',
        'title',
        'description',
        'icon',
        'tone',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];
}
