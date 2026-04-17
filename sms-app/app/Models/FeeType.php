<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeType extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = ['campus_id', 'name', 'is_recurring', 'frequency'];

    protected $casts = [
        'is_recurring' => 'boolean',
    ];

    public function structures(): HasMany
    {
        return $this->hasMany(FeeStructure::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(FeeInvoice::class);
    }
}
