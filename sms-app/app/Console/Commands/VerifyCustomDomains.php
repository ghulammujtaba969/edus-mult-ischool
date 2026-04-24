<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Services\DomainVerificationService;
use Illuminate\Console\Command;

class VerifyCustomDomains extends Command
{
    protected $signature = 'domains:verify';
    protected $description = 'Verify DNS records for custom domains';

    public function handle(DomainVerificationService $verificationService)
    {
        $unverifiedDomains = Domain::where('is_verified', false)->get();
        
        $this->info("Checking " . $unverifiedDomains->count() . " domains...");

        foreach ($unverifiedDomains as $domain) {
            $this->info("Verifying {$domain->domain}...");
            if ($verificationService->verify($domain)) {
                $this->info("SUCCESS: {$domain->domain} verified.");
            } else {
                $this->error("FAILED: {$domain->domain} check failed.");
            }
        }

        $this->info("Verification process complete.");
    }
}
