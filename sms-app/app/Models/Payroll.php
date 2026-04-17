<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    use HasFactory;
    use BelongsToCampus;

    protected $fillable = [
        'campus_id',
        'employee_id',
        'billing_month',
        'basic_salary',
        'allowances',
        'deductions',
        'net_salary',
        'status',
        'payment_date',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'billing_month' => 'date',
        'payment_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
