<?php

namespace App\Http\Controllers;

use App\Models\ExamType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamTypeController extends Controller
{
    public function index(): View
    {
        $examTypes = ExamType::query()->orderBy('name')->get();
        return view('exam-types.index', compact('examTypes'));
    }

    public function create(): View
    {
        return view('exam-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'weightage_percent' => 'required|numeric|min:0|max:100',
        ]);

        ExamType::create([
            'campus_id' => auth()->user()->campus_id,
            'name' => $validated['name'],
            'weightage_percent' => $validated['weightage_percent'],
        ]);

        return redirect()->route('admin.exam-types.index')
            ->with('success', 'Exam type created successfully.');
    }

    public function edit(ExamType $examType): View
    {
        return view('exam-types.edit', compact('examType'));
    }

    public function update(Request $request, ExamType $examType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'weightage_percent' => 'required|numeric|min:0|max:100',
        ]);

        $examType->update($validated);

        return redirect()->route('admin.exam-types.index')
            ->with('success', 'Exam type updated successfully.');
    }

    public function destroy(ExamType $examType): RedirectResponse
    {
        $examType->delete();
        return redirect()->route('admin.exam-types.index')
            ->with('success', 'Exam type deleted successfully.');
    }
}
