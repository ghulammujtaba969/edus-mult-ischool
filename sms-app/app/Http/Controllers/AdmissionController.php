<?php

namespace App\Http\Controllers;

use App\Models\AdmissionInquiry;
use App\Models\Campus;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function create(): View
    {
        $campuses = Campus::all();
        $classes = SchoolClass::all();
        return view('admission-form', compact('campuses', 'classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'campus_id' => 'required|exists:campuses,id',
            'student_name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'school_class_id' => 'required|exists:school_classes,id',
            'address' => 'nullable|string',
        ]);

        AdmissionInquiry::create(array_merge($validated, [
            'status' => 'pending',
        ]));

        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully. Our team will contact you soon!');
    }
}
