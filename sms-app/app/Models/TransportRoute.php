<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportRoute extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'school_id',
        'campus_id',
        'name',
        'route_code',
        'fare',
        'description',
    ];

    public function pickupPoints(): HasMany
    {
        return $this->hasMany(TransportPickupPoint::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TransportAssignment::class);
    }
}
