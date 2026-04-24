<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Plan;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_schools' => School::count(),
            'active_schools' => School::where('status', 'active')->count(),
            'total_plans' => Plan::count(),
            'total_users' => User::count(),
        ];

        $recentSchools = School::with('plan')->latest()->take(5)->get();

        return view('super-admin.dashboard', compact('stats', 'recentSchools'));
    }
}
