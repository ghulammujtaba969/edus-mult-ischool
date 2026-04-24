<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportVehicle extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'vehicle_no',
        'vehicle_model',
        'driver_name',
        'driver_phone',
        'driver_license',
        'capacity',
        'status',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(TransportAssignment::class);
    }
}
