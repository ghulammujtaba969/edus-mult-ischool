<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Plan;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Core Stats
        $stats = [
            'total_schools' => School::count(),
            'active_schools' => School::where('status', 'active')->count(),
            'pending_schools' => School::where('status', 'pending')->count(),
            'suspended_schools' => School::where('status', 'suspended')->count(),
            'trial_schools' => School::whereNotNull('trial_ends_at')->where('trial_ends_at', '>', now())->count(),
            'new_schools_this_month' => School::where('created_at', '>=', now()->startOfMonth())->count(),
            'total_plans' => Plan::count(),
            'total_users' => User::count(),
            'new_users_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
            'mrr' => School::join('plans', 'schools.plan_id', '=', 'plans.id')
                ->where('schools.status', 'active')
                ->sum('plans.monthly_price'),
            'pending_domains' => \App\Models\Domain::where('is_verified', false)->count(),
            'total_domains' => \App\Models\Domain::count(),
        ];

        // 2. Growth Data (Last 6 months)
        $months = collect(range(5, 0))->map(function($i) {
            return Carbon::now()->subMonths($i)->format('M');
        });

        // School Growth
        $registrations = School::select(
            DB::raw('COUNT(*) as count'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->get()
        ->pluck('count', 'month');

        $growthData = $months->map(fn($m) => $registrations->get($m, 0));

        // Revenue Trend
        $revenueRegistrations = School::join('plans', 'schools.plan_id', '=', 'plans.id')
            ->select(
                DB::raw('SUM(plans.monthly_price) as revenue'),
                DB::raw("DATE_FORMAT(schools.created_at, '%b') as month")
            )
            ->where('schools.status', 'active')
            ->where('schools.created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->get()
            ->pluck('revenue', 'month');

        $revenueGrowthData = $months->map(fn($m) => (float) $revenueRegistrations->get($m, 0));

        // User Growth
        $userRegistrations = User::select(
            DB::raw('COUNT(*) as count'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->get()
        ->pluck('count', 'month');

        $userGrowthData = $months->map(fn($m) => $userRegistrations->get($m, 0));

        // Activity Growth (Operations logged per month for the last 6 months)
        $activityCounts = ActivityLog::select(
            DB::raw('COUNT(*) as count'),
            DB::raw("DATE_FORMAT(logged_at, '%b') as month")
        )
        ->where('logged_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->get()
        ->pluck('count', 'month');

        $activityGrowthData = $months->map(fn($m) => $activityCounts->get($m, 0));

        // 3. Plan Distribution & Revenue
        $totalMrr = $stats['mrr'];
        $planDistribution = Plan::withCount('schools')
            ->get()
            ->map(function($plan) use ($totalMrr) {
                $planMrr = School::where('plan_id', $plan->id)->where('status', 'active')->count() * $plan->monthly_price;
                return [
                    'name' => $plan->name,
                    'count' => $plan->schools_count,
                    'price' => $plan->monthly_price,
                    'mrr' => $planMrr,
                    'percentage' => $totalMrr > 0 ? round(($planMrr / $totalMrr) * 100, 1) : 0
                ];
            });

        // 4. Recent Data
        $recentSchools = School::with(['plan', 'primaryDomain'])
            ->withCount(['users as students_count' => function($query) {
                $query->whereHas('student');
            }])
            ->latest()
            ->take(6)
            ->get();

        $recentActivity = ActivityLog::with('user')->latest()->take(6)->get();

        $domainRequests = \App\Models\Domain::with('school')
            ->where('type', 'custom')
            ->latest()
            ->take(5)
            ->get();

        // 5. Top Schools by Usage (Students)
        $topSchools = School::withCount(['users as students_count' => function($query) {
                $query->whereHas('student');
            }])
            ->orderBy('students_count', 'desc')
            ->take(6)
            ->get();

        // 6. Platform Health
        $health = [
            'database' => 'Healthy',
            'storage' => '82%',
            'uptime' => '99.99%',
            'api_latency' => '124ms'
        ];

        return view('super-admin.dashboard', compact(
            'stats',
            'recentSchools',
            'recentActivity',
            'growthData',
            'revenueGrowthData',
            'userGrowthData',
            'activityGrowthData',
            'months',
            'planDistribution',
            'domainRequests',
            'topSchools',
            'health'
        ));
    }
}
