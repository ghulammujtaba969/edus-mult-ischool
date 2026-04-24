<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdmissionInquiryController extends Controller
{
    public function index(): View
    {
        $inquiries = AdmissionInquiry::with('schoolClass')->latest()->get();
        return view('admin.admissions.index', compact('inquiries'));
    }

    public function show(AdmissionInquiry $admissionInquiry): View
    {
        return view('admin.admissions.show', compact('admissionInquiry'));
    }

    public function update(Request $request, AdmissionInquiry $admissionInquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'remarks' => 'nullable|string',
        ]);

        $admissionInquiry->update($validated);

        return redirect()->route('admin.admission-inquiries.index')
            ->with('success', 'Inquiry status updated successfully.');
    }

    public function destroy(AdmissionInquiry $admissionInquiry): RedirectResponse
    {
        $admissionInquiry->delete();
        return redirect()->route('admin.admission-inquiries.index')
            ->with('success', 'Inquiry deleted successfully.');
    }
}
