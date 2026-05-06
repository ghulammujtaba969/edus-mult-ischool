<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportPickupPoint extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'school_id',
        'campus_id',
        'transport_route_id',
        'name',
        'pickup_time',
        'additional_fare',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(TransportRoute::class, 'transport_route_id');
    }
}
