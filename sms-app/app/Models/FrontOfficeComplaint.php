<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontOfficeComplaint extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'complaint_by',
        'phone',
        'date',
        'description',
        'action_taken',
        'assigned_to',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
