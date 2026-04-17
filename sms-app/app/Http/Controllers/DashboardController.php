<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\FeeInvoice;
use App\Models\FeePayment;
use App\Models\SchoolClass;
use App\Services\CampusManager;
use App\Services\Contracts\ReportServiceInterface;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly ReportServiceInterface $reportService,
        private readonly CampusManager $campusManager,
    ) {
    }

    public function index(): View
    {
        $metrics = $this->reportService->dashboardMetrics();
        $monthStart = Carbon::now()->startOfMonth();

        $recentPayments = FeePayment::query()
            ->with(['student.currentAcademicRecord.schoolClass'])
            ->latest('payment_date')
            ->take(5)
            ->get();

        $collectionByClass = SchoolClass::query()
            ->withCount(['sections'])
            ->orderBy('order_seq')
            ->get()
            ->map(function (SchoolClass $class) use ($monthStart) {
                $invoices = FeeInvoice::query()
                    ->whereHas('student.currentAcademicRecord', fn ($query) => $query->where('school_class_id', $class->id))
                    ->whereYear('billing_month', $monthStart->year)
                    ->whereMonth('billing_month', $monthStart->month)
                    ->get();

                $net = (float) $invoices->sum('net_amount');
                $paid = (float) $invoices->sum('paid_amount');

                return [
                    'name' => $class->name,
                    'percentage' => $net > 0 ? round(($paid / $net) * 100) : 0,
                ];
            })
            ->take(6);

        $activities = ActivityLog::query()
            ->latest('logged_at')
            ->take(5)
            ->get();

        return view('dashboard.index', [
            'metrics' => $metrics,
            'recentPayments' => $recentPayments,
            'collectionByClass' => $collectionByClass,
            'activities' => $activities,
            'activeCampus' => $this->campusManager->activeCampus(),
            'activeAcademicYear' => $this->campusManager->activeAcademicYear(),
        ]);
    }
}
