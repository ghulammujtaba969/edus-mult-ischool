<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\FeeInvoice;
use App\Models\FeeStructure;
use App\Models\FeeType;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentAcademicRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FeeInvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'status', 'month']);

        $invoices = FeeInvoice::query()
            ->with(['student.user', 'feeType'])
            ->when($filters['q'] ?? null, function ($query, $search) {
                $query->where('challan_no', 'like', "%{$search}%")
                    ->orWhereHas('student.user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            })
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['month'] ?? null, fn ($query, $month) => $query->whereDate('billing_month', $month))
            ->latest()
            ->paginate(15);

        return view('fee-invoices.index', compact('invoices', 'filters'));
    }

    public function create(): View
    {
        $academicYears = AcademicYear::query()->latest()->get();
        $classes = SchoolClass::query()->orderBy('order_seq')->get();
        $feeTypes = FeeType::query()->where('is_recurring', true)->get();

        return view('fee-invoices.generate', compact('academicYears', 'classes', 'feeTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'billing_month' => 'required|date',
        ]);

        $academicYearId = $validated['academic_year_id'];
        $feeTypeId = $validated['fee_type_id'];
        $billingMonth = \Carbon\Carbon::parse($validated['billing_month'])->startOfMonth();

        // Get students in the class/campus
        $students = StudentAcademicRecord::query()
            ->where('academic_year_id', $academicYearId)
            ->where('is_current', true)
            ->when($validated['school_class_id'] ?? null, fn ($q, $cid) => $q->where('school_class_id', $cid))
            ->with(['student', 'schoolClass'])
            ->get();

        $count = 0;
        DB::transaction(function () use ($students, $academicYearId, $feeTypeId, $billingMonth, &$count) {
            foreach ($students as $record) {
                // Get amount from fee structure
                $structure = FeeStructure::where('academic_year_id', $academicYearId)
                    ->where('school_class_id', $record->school_class_id)
                    ->where('fee_type_id', $feeTypeId)
                    ->first();

                if (!$structure) continue;

                // Check if invoice already exists
                $exists = FeeInvoice::where('student_id', $record->student_id)
                    ->where('fee_type_id', $feeTypeId)
                    ->whereDate('billing_month', $billingMonth)
                    ->exists();

                if ($exists) continue;

                FeeInvoice::create([
                    'campus_id' => auth()->user()->campus_id,
                    'student_id' => $record->student_id,
                    'academic_year_id' => $academicYearId,
                    'fee_type_id' => $feeTypeId,
                    'billing_month' => $billingMonth,
                    'amount' => $structure->amount,
                    'net_amount' => $structure->amount,
                    'balance_amount' => $structure->amount,
                    'due_date' => $billingMonth->copy()->day($structure->due_day),
                    'status' => 'unpaid',
                    'challan_no' => 'CHL-' . strtoupper(uniqid()),
                ]);
                $count++;
            }
        });

        return redirect()->route('admin.fee-invoices.index')
            ->with('success', "$count invoices generated successfully.");
    }

    public function show(FeeInvoice $feeInvoice): View
    {
        $feeInvoice->load(['student.user', 'student.guardian', 'student.currentAcademicRecord.schoolClass', 'feeType', 'payments']);
        return view('fee-invoices.show', compact('feeInvoice'));
    }
}
