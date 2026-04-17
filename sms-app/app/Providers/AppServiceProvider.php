<?php

namespace App\Providers;

use App\Services\AttendanceService;
use App\Services\CampusManager;
use App\Services\ChallanService;
use App\Services\Contracts\AttendanceServiceInterface;
use App\Services\Contracts\ChallanServiceInterface;
use App\Services\Contracts\FeeServiceInterface;
use App\Services\Contracts\ReportServiceInterface;
use App\Services\Contracts\ResultServiceInterface;
use App\Services\Contracts\SmsServiceInterface;
use App\Services\FeeService;
use App\Services\ReportService;
use App\Services\ResultService;
use App\Services\SmsService;
use App\Models\Campus;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CampusManager::class);
        $this->app->bind(FeeServiceInterface::class, FeeService::class);
        $this->app->bind(AttendanceServiceInterface::class, AttendanceService::class);
        $this->app->bind(ResultServiceInterface::class, ResultService::class);
        $this->app->bind(SmsServiceInterface::class, SmsService::class);
        $this->app->bind(ReportServiceInterface::class, ReportService::class);
        $this->app->bind(ChallanServiceInterface::class, ChallanService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $manager = app(CampusManager::class);

            $view->with('layoutActiveCampus', $manager->activeCampus());
            $view->with('layoutAcademicYear', $manager->activeAcademicYear());
            $view->with('layoutCampuses', Campus::query()->orderBy('name')->get());
        });
    }
}
