<?php

namespace App\Services;

use App\Models\School;
use App\Models\Domain;
use Illuminate\Http\Request;

class TenantManager
{
    private ?int $schoolId = null;
    private ?School $school = null;

    public function resolveFromRequest(Request $request): void
    {
        $host = $request->getHost();
        $domain = Domain::where('domain', $host)->where('is_verified', true)->first();

        if ($domain) {
            $this->schoolId = $domain->school_id;
            $this->school = $domain->school;
        } else {
            // Fallback for main domain access /school/{slug}
            // Or if it's a subdomain not in DB yet
            $slug = explode('.', $host)[0];
            $school = School::where('slug', $slug)->first();
            if ($school) {
                $this->schoolId = $school->id;
                $this->school = $school;
            }
        }

        // Final fallback: use authenticated user's school if still not resolved
        if (!$this->schoolId && auth()->check() && auth()->user()->school_id) {
            $this->schoolId = auth()->user()->school_id;
            $this->school = auth()->user()->school;
        }
    }

    public function getSchoolId(): ?int
    {
        return $this->schoolId;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchoolId(int $id): void
    {
        $this->schoolId = $id;
        $this->school = School::find($id);
    }
}
