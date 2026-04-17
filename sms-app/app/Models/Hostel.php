<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hostel extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'name',
        'type',
        'address',
        'city',
        'capacity',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(HostelRoom::class);
    }
}
