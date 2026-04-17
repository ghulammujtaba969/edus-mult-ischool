<?php

namespace App\Http\Middleware;

use App\Services\CampusManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCampusContext
{
    public function __construct(private readonly CampusManager $campusManager)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->campusManager->hydrateFromRequest($request);

        return $next($request);
    }
}
