<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontOfficeVisitor extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'name',
        'phone',
        'purpose',
        'id_card',
        'no_of_person',
        'date',
        'in_time',
        'out_time',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
