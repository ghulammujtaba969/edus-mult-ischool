<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LibraryBook extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'school_id',
        'campus_id',
        'title',
        'author',
        'isbn_no',
        'publisher',
        'rack_no',
        'quantity',
        'available_quantity',
        'price',
    ];

    public function issues(): HasMany
    {
        return $this->hasMany(LibraryIssue::class);
    }
}
