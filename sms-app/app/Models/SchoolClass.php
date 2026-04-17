<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = ['campus_id', 'name', 'level', 'order_seq'];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
