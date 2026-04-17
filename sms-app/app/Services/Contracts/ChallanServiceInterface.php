<?php

namespace App\Services\Contracts;

interface ChallanServiceInterface
{
    public function buildInvoicePayload(int $invoiceId): array;
}
