<?php

namespace App\Services\Contracts;

interface ResultServiceInterface
{
    public function studentResultSummary(int $studentId): array;
}
