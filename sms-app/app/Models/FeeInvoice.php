<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeInvoice extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'student_id',
        'academic_year_id',
        'fee_type_id',
        'billing_month',
        'amount',
        'discount_amount',
        'fine_amount',
        'net_amount',
        'paid_amount',
        'balance_amount',
        'due_date',
        'status',
        'challan_no',
    ];

    protected $casts = [
        'billing_month' => 'date',
        'due_date' => 'date',
        'status' => InvoiceStatus::class,
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(FeePayment::class);
    }
}
