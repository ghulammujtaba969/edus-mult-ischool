<?php

namespace App\Services;

use App\Models\FeeInvoice;
use App\Services\Contracts\FeeServiceInterface;
use Carbon\Carbon;

class FeeService implements FeeServiceInterface
{
    public function monthlyCollectionSummary(): array
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        return [
            'collected' => (float) FeeInvoice::query()
                ->whereBetween('due_date', [$start, $end])
                ->sum('paid_amount'),
            'pending' => (float) FeeInvoice::query()
                ->whereBetween('due_date', [$start, $end])
                ->sum('balance_amount'),
        ];
    }
}
