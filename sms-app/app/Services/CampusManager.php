<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Campus;
use Illuminate\Http\Request;

class CampusManager
{
    private ?int $scopeCampusId = null;
    private ?Campus $activeCampus = null;
    private ?AcademicYear $activeAcademicYear = null;

    public function hydrateFromRequest(Request $request): void
    {
        $user = $request->user();

        if (! $user) {
            return;
        }

        if ($user->isSuperAdmin()) {
            $selectedCampusId = (int) $request->session()->get('active_campus_id');

            if (! $selectedCampusId) {
                $selectedCampusId = (int) Campus::query()->value('id');
                if ($selectedCampusId) {
                    $request->session()->put('active_campus_id', $selectedCampusId);
                }
            }

            $this->scopeCampusId = $selectedCampusId ?: null;
        } else {
            $this->scopeCampusId = $user->campus_id;
        }

        $this->activeCampus = $this->scopeCampusId
            ? Campus::query()->find($this->scopeCampusId)
            : null;

        $this->activeAcademicYear = $this->scopeCampusId
            ? AcademicYear::query()->where('campus_id', $this->scopeCampusId)->where('is_current', true)->first()
            : null;
    }

    public function scopeCampusId(): ?int
    {
        return $this->scopeCampusId;
    }

    public function activeCampus(): ?Campus
    {
        return $this->activeCampus;
    }

    public function activeAcademicYear(): ?AcademicYear
    {
        return $this->activeAcademicYear;
    }
}
