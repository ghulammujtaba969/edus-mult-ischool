<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolClassController extends Controller
{
    public function index(): View
    {
        $classes = SchoolClass::query()
            ->withCount('sections')
            ->orderBy('order_seq')
            ->get();

        return view('classes.index', compact('classes'));
    }

    public function create(): View
    {
        return view('classes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:255',
            'order_seq' => 'required|integer|min:0',
        ]);

        SchoolClass::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function edit(SchoolClass $class): View
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:255',
            'order_seq' => 'required|integer|min:0',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $class): RedirectResponse
    {
        if ($class->sections()->exists()) {
            return back()->with('error', 'Cannot delete class with existing sections.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class deleted successfully.');
    }
}
