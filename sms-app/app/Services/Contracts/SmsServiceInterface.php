<?php

namespace App\Services\Contracts;

interface SmsServiceInterface
{
    public function queueAbsenceAlert(array $payload): void;
}
