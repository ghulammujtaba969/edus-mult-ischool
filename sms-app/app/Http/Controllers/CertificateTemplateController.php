<?php

namespace App\Http\Controllers;

use App\Models\CertificateTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificateTemplateController extends Controller
{
    public function index(): View
    {
        $templates = CertificateTemplate::latest()->get();
        return view('certificates.templates.index', compact('templates'));
    }

    public function create(): View
    {
        return view('certificates.templates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'certificate_type' => 'required|string',
            'content' => 'required|string',
        ]);

        CertificateTemplate::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id
        ]));

        return redirect()->route('admin.certificate-templates.index')
            ->with('success', 'Certificate template created.');
    }
}
