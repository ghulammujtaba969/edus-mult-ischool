<?php

namespace App\Http\Controllers;

use App\Models\TransportRoute;
use App\Models\TransportPickupPoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransportRouteController extends Controller
{
    public function index(): View
    {
        $routes = TransportRoute::withCount('pickupPoints')->latest()->get();
        return view('transport.routes.index', compact('routes'));
    }

    public function create(): View
    {
        return view('transport.routes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'route_code' => 'nullable|string|max:50',
            'fare' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        TransportRoute::create($validated);

        return redirect()->route('admin.transport-routes.index')
            ->with('success', 'Route created successfully.');
    }

    public function show(TransportRoute $transportRoute): View
    {
        $transportRoute->load('pickupPoints');
        return view('transport.routes.show', ['route' => $transportRoute]);
    }

    public function edit(TransportRoute $transportRoute): View
    {
        return view('transport.routes.edit', ['route' => $transportRoute]);
    }

    public function update(Request $request, TransportRoute $transportRoute): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'route_code' => 'nullable|string|max:50',
            'fare' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $transportRoute->update($validated);

        return redirect()->route('admin.transport-routes.index')
            ->with('success', 'Route updated successfully.');
    }

    public function addPickupPoint(Request $request, TransportRoute $transportRoute): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pickup_time' => 'nullable',
            'additional_fare' => 'required|numeric|min:0',
        ]);

        $transportRoute->pickupPoints()->create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id
        ]));

        return back()->with('success', 'Pickup point added.');
    }
}
