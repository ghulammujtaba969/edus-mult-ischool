<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostelAllocation extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'hostel_room_id',
        'student_id',
        'bed_no',
        'allocated_at',
        'vacated_at',
        'status',
        'remarks',
    ];

    protected $casts = [
        'allocated_at' => 'date',
        'vacated_at' => 'date',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(HostelRoom::class, 'hostel_room_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
