<?php

namespace App\Http\Controllers;

use App\Models\OnlineExam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnlineExamController extends Controller
{
    public function index(): View
    {
        $exams = OnlineExam::withCount('questions')->latest()->get();
        return view('academic.online-exams.index', compact('exams'));
    }

    public function create(): View
    {
        return view('academic.online-exams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'exam_title' => 'required|string|max:255',
            'exam_from' => 'required|date',
            'exam_to' => 'required|date|after:exam_from',
            'duration_minutes' => 'required|integer|min:1',
            'minimum_percentage' => 'required|numeric|min:0|max:100',
        ]);

        OnlineExam::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'is_active' => true,
        ]));

        return redirect()->route('admin.online-exams.index')
            ->with('success', 'Online exam created successfully.');
    }

    public function edit(OnlineExam $onlineExam): View
    {
        return view('academic.online-exams.edit', compact('onlineExam'));
    }

    public function update(Request $request, OnlineExam $onlineExam): RedirectResponse
    {
        $validated = $request->validate([
            'exam_title' => 'required|string|max:255',
            'exam_from' => 'required|date',
            'exam_to' => 'required|date|after:exam_from',
            'duration_minutes' => 'required|integer|min:1',
            'minimum_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'required|boolean',
        ]);

        $onlineExam->update($validated);

        return redirect()->route('admin.online-exams.index')
            ->with('success', 'Online exam updated successfully.');
    }

    public function destroy(OnlineExam $onlineExam): RedirectResponse
    {
        $onlineExam->delete();
        return redirect()->route('admin.online-exams.index')
            ->with('success', 'Online exam deleted successfully.');
    }
}
