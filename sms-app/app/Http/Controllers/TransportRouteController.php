<?php

namespace App\Http\Controllers;

use App\Models\TransportRoute;
use App\Models\TransportPickupPoint;
use App\Models\Campus;
use App\Services\CampusManager;
use App\Services\TenantManager;
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

        $tenant = $this->tenantPayload($request);
        if (! $tenant['campus_id']) {
            return back()->withInput()->with('error', 'Please select an active campus before creating a route.');
        }

        TransportRoute::create(array_merge($validated, $tenant));

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

    public function destroy(TransportRoute $transportRoute): RedirectResponse
    {
        if ($transportRoute->assignments()->exists()) {
            return back()->with('error', 'This route has transport assignments and cannot be deleted.');
        }

        $transportRoute->delete();

        return redirect()->route('admin.transport-routes.index')
            ->with('success', 'Route deleted successfully.');
    }

    public function addPickupPoint(Request $request, TransportRoute $transportRoute): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pickup_time' => 'nullable',
            'additional_fare' => 'required|numeric|min:0',
        ]);

        $tenant = $this->tenantPayload($request);
        if (! $tenant['campus_id']) {
            return back()->withInput()->with('error', 'Please select an active campus before adding a pickup point.');
        }

        $transportRoute->pickupPoints()->create(array_merge($validated, $tenant));

        return back()->with('success', 'Pickup point added.');
    }

    private function tenantPayload(Request $request): array
    {
        $user = $request->user();
        $schoolId = app()->bound(TenantManager::class) ? app(TenantManager::class)->getSchoolId() : null;
        $schoolId = $schoolId ?: $user?->school_id;

        $campusId = app()->bound(CampusManager::class) ? app(CampusManager::class)->getScopeCampusId() : null;
        $campusId = $campusId ?: $request->session()->get('active_campus_id') ?: $user?->campus_id;

        if (! $campusId && $schoolId) {
            $campusId = Campus::where('school_id', $schoolId)->value('id');
            if ($campusId) {
                $request->session()->put('active_campus_id', $campusId);
            }
        }

        return [
            'school_id' => $schoolId,
            'campus_id' => $campusId,
        ];
    }
}
