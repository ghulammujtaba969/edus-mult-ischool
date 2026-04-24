<?php

namespace App\Http\Middleware;

use App\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantResolver
{
    public function __construct(protected TenantManager $tenantManager)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->tenantManager->resolveFromRequest($request);

        if (!$this->tenantManager->getSchoolId()) {
            // If it's a super admin route, allow it without a tenant
            if ($request->is('super-admin*')) {
                return $next($request);
            }

            // Otherwise, if we can't resolve the tenant, redirect to landing or error
            // For now, just continue but scoping will be empty
        }

        return $next($request);
    }
}
