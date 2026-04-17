<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = ['campus_id', 'name', 'code', 'subject_type', 'is_optional'];

    protected $casts = [
        'is_optional' => 'boolean',
    ];
}
