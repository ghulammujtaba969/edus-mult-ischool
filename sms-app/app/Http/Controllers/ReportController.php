<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\FeeInvoice;
use App\Models\InventoryItem;
use App\Models\Mark;
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

    public function financials(Request $request): View
    {
        $year = $request->input('year', date('Y'));

        $income = FeeInvoice::whereYear('billing_month', $year)->sum('paid_amount');
        $expenses = Expense::whereYear('expense_date', $year)->sum('amount');

        $monthly_income = FeeInvoice::whereYear('billing_month', $year)
            ->selectRaw('MONTH(billing_month) as month, SUM(paid_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthly_expense = Expense::whereYear('expense_date', $year)
            ->selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return view('reports.financials', compact('income', 'expenses', 'monthly_income', 'monthly_expense', 'year'));
    }

    public function inventory(): View
    {
        $items = InventoryItem::with('supplier')->get();
        return view('reports.inventory', compact('items'));
    }

    public function transcripts(Request $request): View
    {
        $students = Student::with(['user', 'schoolClass', 'section'])->get();
        return view('reports.transcripts', compact('students'));
    }

    public function showTranscript(Student $student): View
    {
        $student->load(['user', 'schoolClass', 'section', 'academicYear']);

        $marks = Mark::with(['subject', 'exam.examType'])
            ->where('student_id', $student->id)
            ->get()
            ->groupBy('exam.examType.name');

        $gradeScales = GradeScale::orderBy('min_percent', 'desc')->get();

        return view('reports.transcript-show', compact('student', 'marks', 'gradeScales'));
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
