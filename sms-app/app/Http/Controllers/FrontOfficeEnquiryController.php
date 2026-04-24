<?php

namespace App\Http\Controllers;

use App\Models\FrontOfficeEnquiry;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontOfficeEnquiryController extends Controller
{
    public function index(): View
    {
        $enquiries = FrontOfficeEnquiry::with('schoolClass')->latest()->get();
        return view('front-office.enquiries.index', compact('enquiries'));
    }

    public function create(): View
    {
        $classes = SchoolClass::all();
        return view('front-office.enquiries.create', compact('classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'date' => 'required|date',
            'next_follow_up_date' => 'nullable|date|after_or_equal:date',
            'source' => 'nullable|string',
            'status' => 'required|string|in:active,passive,won,lost',
            'class_id' => 'nullable|exists:school_classes,id',
            'description' => 'nullable|string',
        ]);

        FrontOfficeEnquiry::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id
        ]));

        return redirect()->route('admin.front-office-enquiries.index')
            ->with('success', 'Admission enquiry added.');
    }
}
