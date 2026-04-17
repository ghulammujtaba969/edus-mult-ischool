<?php

namespace App\Services;

use App\Services\Contracts\SmsServiceInterface;
use Illuminate\Support\Facades\Log;

class SmsService implements SmsServiceInterface
{
    public function queueAbsenceAlert(array $payload): void
    {
        Log::info('SMS queued', $payload);
    }
}
