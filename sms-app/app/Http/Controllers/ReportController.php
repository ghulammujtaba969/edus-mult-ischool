<?php

namespace App\Http\Controllers;

use App\Models\FeeInvoice;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index');
    }

    public function attendance(Request $request): View
    {
        $date = $request->input('date', date('Y-m-d'));
        $attendance = StudentAttendance::with(['student.user', 'section.schoolClass'])
            ->whereDate('attendance_date', $date)
            ->get();

        return view('reports.attendance', compact('attendance', 'date'));
    }

    public function fees(Request $request): View
    {
        $month = $request->input('month', date('Y-m'));
        $invoices = FeeInvoice::with(['student.user', 'feeType'])
            ->whereDate('billing_month', $month . '-01')
            ->get();

        $summary = [
            'total' => $invoices->sum('net_amount'),
            'paid' => $invoices->sum('paid_amount'),
            'balance' => $invoices->sum('balance_amount'),
        ];

        return view('reports.fees', compact('invoices', 'month', 'summary'));
    }
}
