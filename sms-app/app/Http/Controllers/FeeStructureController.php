<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\FeeStructure;
use App\Models\FeeType;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeStructureController extends Controller
{
    public function index(): View
    {
        $structures = FeeStructure::with(['academicYear', 'schoolClass', 'feeType'])
            ->orderBy('academic_year_id', 'desc')
            ->orderBy('school_class_id')
            ->get();

        return view('fee-structures.index', compact('structures'));
    }

    public function create(): View
    {
        $academicYears = AcademicYear::query()->latest()->get();
        $classes = SchoolClass::query()->orderBy('order_seq')->get();
        $feeTypes = FeeType::query()->orderBy('name')->get();

        return view('fee-structures.create', compact('academicYears', 'classes', 'feeTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'due_day' => 'required|integer|min:1|max:31',
            'effective_from' => 'nullable|date',
        ]);

        FeeStructure::updateOrCreate(
            [
                'campus_id' => auth()->user()->campus_id,
                'academic_year_id' => $validated['academic_year_id'],
                'school_class_id' => $validated['school_class_id'],
                'fee_type_id' => $validated['fee_type_id'],
            ],
            $validated
        );

        return redirect()->route('admin.fee-structures.index')
            ->with('success', 'Fee structure saved successfully.');
    }

    public function edit(FeeStructure $feeStructure): View
    {
        $academicYears = AcademicYear::query()->latest()->get();
        $classes = SchoolClass::query()->orderBy('order_seq')->get();
        $feeTypes = FeeType::query()->orderBy('name')->get();

        return view('fee-structures.edit', compact('feeStructure', 'academicYears', 'classes', 'feeTypes'));
    }

    public function update(Request $request, FeeStructure $feeStructure): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'due_day' => 'required|integer|min:1|max:31',
            'effective_from' => 'nullable|date',
        ]);

        $feeStructure->update($validated);

        return redirect()->route('admin.fee-structures.index')
            ->with('success', 'Fee structure updated successfully.');
    }

    public function destroy(FeeStructure $feeStructure): RedirectResponse
    {
        $feeStructure->delete();

        return redirect()->route('admin.fee-structures.index')
            ->with('success', 'Fee structure deleted successfully.');
    }
}
