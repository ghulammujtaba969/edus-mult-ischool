<?php

namespace App\Http\Controllers;

use App\Models\FrontOfficeComplaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontOfficeComplaintController extends Controller
{
    public function index(): View
    {
        $complaints = FrontOfficeComplaint::latest()->get();
        return view('front-office.complaints.index', compact('complaints'));
    }

    public function create(): View
    {
        return view('front-office.complaints.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'complaint_by' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        FrontOfficeComplaint::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'status' => 'pending'
        ]));

        return redirect()->route('admin.front-office-complaints.index')
            ->with('success', 'Complaint registered.');
    }

    public function update(Request $request, FrontOfficeComplaint $frontOfficeComplaint): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,in_progress,resolved',
            'action_taken' => 'nullable|string',
        ]);

        $frontOfficeComplaint->update($validated);

        return redirect()->route('admin.front-office-complaints.index')
            ->with('success', 'Complaint status updated.');
    }
}
