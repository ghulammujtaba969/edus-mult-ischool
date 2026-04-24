<?php

namespace App\Http\Controllers;

use App\Models\IdCardTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IdCardTemplateController extends Controller
{
    public function index(): View
    {
        $templates = IdCardTemplate::latest()->get();
        return view('id-cards.templates.index', compact('templates'));
    }

    public function create(): View
    {
        return view('id-cards.templates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_type' => 'required|string|in:student,staff',
        ]);

        IdCardTemplate::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id
        ]));

        return redirect()->route('admin.id-card-templates.index')
            ->with('success', 'ID card template created.');
    }
}
