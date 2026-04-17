<?php

namespace App\Services\Contracts;

interface FeeServiceInterface
{
    public function monthlyCollectionSummary(): array;
}
