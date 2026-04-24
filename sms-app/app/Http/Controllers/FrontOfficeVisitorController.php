<?php

namespace App\Http\Controllers;

use App\Models\FrontOfficeVisitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontOfficeVisitorController extends Controller
{
    public function index(): View
    {
        $visitors = FrontOfficeVisitor::latest()->get();
        return view('front-office.visitors.index', compact('visitors'));
    }

    public function create(): View
    {
        return view('front-office.visitors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'purpose' => 'nullable|string|max:255',
            'no_of_person' => 'required|integer|min:1',
            'date' => 'required|date',
            'in_time' => 'nullable',
            'out_time' => 'nullable',
            'note' => 'nullable|string',
        ]);

        FrontOfficeVisitor::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id
        ]));

        return redirect()->route('admin.front-office-visitors.index')
            ->with('success', 'Visitor log added.');
    }

    public function update(Request $request, FrontOfficeVisitor $frontOfficeVisitor): RedirectResponse
    {
        $validated = $request->validate([
            'out_time' => 'required',
        ]);

        $frontOfficeVisitor->update($validated);

        return redirect()->route('admin.front-office-visitors.index')
            ->with('success', 'Visitor check-out updated.');
    }
}
