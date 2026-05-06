<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $query = School::with(['plan', 'primaryDomain']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schools = $query->latest()->paginate(10)->withQueryString();
        $plans = Plan::where('is_active', true)->get();

        return view('super-admin.subscriptions.index', compact('schools', 'plans'));
    }

    public function edit(School $school): View
    {
        $plans = Plan::where('is_active', true)->get();
        return view('super-admin.subscriptions.edit', compact('school', 'plans'));
    }

    public function update(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:active,suspended,pending',
            'trial_ends_at' => 'nullable|date',
        ]);

        $school->update($validated);

        return redirect()->route('super-admin.subscriptions.index')
            ->with('success', 'Subscription updated successfully for ' . $school->name);
    }
}
