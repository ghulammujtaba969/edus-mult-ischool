<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeTypeController extends Controller
{
    public function index(): View
    {
        $feeTypes = FeeType::query()->orderBy('name')->get();
        return view('fee-types.index', compact('feeTypes'));
    }

    public function create(): View
    {
        return view('fee-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_recurring' => 'boolean',
            'frequency' => 'required|in:monthly,quarterly,half_yearly,yearly,one_time',
        ]);

        FeeType::create([
            'campus_id' => auth()->user()->campus_id,
            'name' => $validated['name'],
            'is_recurring' => $request->has('is_recurring'),
            'frequency' => $validated['frequency'],
        ]);

        return redirect()->route('admin.fee-types.index')
            ->with('success', 'Fee type created successfully.');
    }

    public function edit(FeeType $feeType): View
    {
        return view('fee-types.edit', compact('feeType'));
    }

    public function update(Request $request, FeeType $feeType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_recurring' => 'boolean',
            'frequency' => 'required|in:monthly,quarterly,half_yearly,yearly,one_time',
        ]);

        $feeType->update([
            'name' => $validated['name'],
            'is_recurring' => $request->has('is_recurring'),
            'frequency' => $validated['frequency'],
        ]);

        return redirect()->route('admin.fee-types.index')
            ->with('success', 'Fee type updated successfully.');
    }

    public function destroy(FeeType $feeType): RedirectResponse
    {
        if ($feeType->invoices()->exists() || $feeType->structures()->exists()) {
            return back()->with('error', 'Cannot delete fee type already in use.');
        }

        $feeType->delete();

        return redirect()->route('admin.fee-types.index')
            ->with('success', 'Fee type deleted successfully.');
    }
}
