<?php

namespace App\Models\Concerns;

use App\Services\TenantManager;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToSchool
{
    public static function bootBelongsToSchool(): void
    {
        static::creating(function ($model): void {
            if (! empty($model->school_id) || ! app()->bound(TenantManager::class)) {
                return;
            }

            $schoolId = app(TenantManager::class)->getSchoolId();

            if ($schoolId) {
                $model->school_id = $schoolId;
            }
        });

        static::addGlobalScope('school', function (Builder $builder): void {
            if (! app()->bound(TenantManager::class)) {
                return;
            }

            $schoolId = app(TenantManager::class)->getSchoolId();

            if ($schoolId) {
                $builder->where($builder->qualifyColumn('school_id'), $schoolId);
            }
        });
    }
}
