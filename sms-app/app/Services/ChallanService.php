<?php

namespace App\Services;

use App\Models\FeeInvoice;
use App\Services\Contracts\ChallanServiceInterface;

class ChallanService implements ChallanServiceInterface
{
    public function buildInvoicePayload(int $invoiceId): array
    {
        $invoice = FeeInvoice::query()->with('student.guardian')->findOrFail($invoiceId);

        return [
            'invoice' => $invoice,
            'student' => $invoice->student,
            'guardian' => $invoice->student?->guardian,
        ];
    }
}
