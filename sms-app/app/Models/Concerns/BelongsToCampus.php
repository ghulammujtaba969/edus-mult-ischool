<?php

namespace App\Models\Concerns;

use App\Services\CampusManager;
use App\Services\TenantManager;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToCampus
{
    public static function bootBelongsToCampus(): void
    {
        static::creating(function ($model): void {
            if (empty($model->school_id) && app()->bound(TenantManager::class)) {
                $model->school_id = app(TenantManager::class)->getSchoolId();
            }

            if (empty($model->campus_id) && app()->bound(CampusManager::class)) {
                $model->campus_id = app(CampusManager::class)->getScopeCampusId();
            }
        });

        static::addGlobalScope('campus', function (Builder $builder): void {
            if (app()->bound(TenantManager::class)) {
                $schoolId = app(TenantManager::class)->getSchoolId();
                if ($schoolId) {
                    $builder->where($builder->qualifyColumn('school_id'), $schoolId);
                }
            }

            if (app()->bound(CampusManager::class)) {
                $campusId = app(CampusManager::class)->getScopeCampusId();
                if ($campusId) {
                    $builder->where($builder->qualifyColumn('campus_id'), $campusId);
                }
            }
        });
    }
}
