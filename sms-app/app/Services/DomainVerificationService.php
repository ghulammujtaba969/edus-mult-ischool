<?php

namespace App\Services;

use App\Models\Domain;
use Illuminate\Support\Facades\Log;

class DomainVerificationService
{
    /**
     * Verify a custom domain's DNS records.
     */
    public function verify(Domain $domain): bool
    {
        if ($domain->type === 'subdomain') {
            $domain->update(['is_verified' => true, 'dns_verified_at' => now()]);
            return true;
        }

        $host = $domain->domain;
        $expectedIp = gethostbyname(parse_url(config('app.url'), PHP_URL_HOST));
        
        $domain->increment('dns_check_count');

        try {
            // Check A record or CNAME
            $dns = dns_get_record($host, DNS_A + DNS_CNAME);
            $isValid = false;

            foreach ($dns as $record) {
                if ($record['type'] === 'A' && $record['ip'] === $expectedIp) {
                    $isValid = true;
                    break;
                }
                if ($record['type'] === 'CNAME' && $record['target'] === parse_url(config('app.url'), PHP_URL_HOST)) {
                    $isValid = true;
                    break;
                }
            }

            if ($isValid) {
                $domain->update([
                    'is_verified' => true,
                    'dns_verified_at' => now(),
                    'last_dns_error' => null
                ]);
                return true;
            }

            $domain->update(['last_dns_error' => 'DNS records do not match our platform. Please point your domain to ' . $expectedIp]);

        } catch (\Exception $e) {
            Log::error("Domain Verification failed for {$host}: " . $e->getMessage());
            $domain->update(['last_dns_error' => 'DNS lookup failed. Please try again later.']);
        }

        return false;
    }
}
