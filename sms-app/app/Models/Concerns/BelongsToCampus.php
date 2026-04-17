<?php

namespace App\Models\Concerns;

use App\Services\CampusManager;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToCampus
{
    public static function bootBelongsToCampus(): void
    {
        static::creating(function ($model): void {
            if (! empty($model->campus_id) || ! app()->bound(CampusManager::class)) {
                return;
            }

            $campusId = app(CampusManager::class)->scopeCampusId();

            if ($campusId) {
                $model->campus_id = $campusId;
            }
        });

        static::addGlobalScope('campus', function (Builder $builder): void {
            if (! app()->bound(CampusManager::class)) {
                return;
            }

            $campusId = app(CampusManager::class)->scopeCampusId();

            if ($campusId) {
                $builder->where($builder->qualifyColumn('campus_id'), $campusId);
            }
        });
    }
}
