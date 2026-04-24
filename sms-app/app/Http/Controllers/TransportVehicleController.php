<?php

namespace App\Http\Controllers;

use App\Models\TransportVehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransportVehicleController extends Controller
{
    public function index(): View
    {
        $vehicles = TransportVehicle::latest()->get();
        return view('transport.vehicles.index', compact('vehicles'));
    }

    public function create(): View
    {
        return view('transport.vehicles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'vehicle_no' => 'required|string|unique:transport_vehicles,vehicle_no',
            'vehicle_model' => 'nullable|string',
            'driver_name' => 'nullable|string',
            'driver_phone' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,maintenance,inactive',
        ]);

        TransportVehicle::create($validated);

        return redirect()->route('admin.transport-vehicles.index')
            ->with('success', 'Vehicle added successfully.');
    }

    public function edit(TransportVehicle $transportVehicle): View
    {
        return view('transport.vehicles.edit', ['vehicle' => $transportVehicle]);
    }

    public function update(Request $request, TransportVehicle $transportVehicle): RedirectResponse
    {
        $validated = $request->validate([
            'vehicle_no' => 'required|string|unique:transport_vehicles,vehicle_no,' . $transportVehicle->id,
            'vehicle_model' => 'nullable|string',
            'driver_name' => 'nullable|string',
            'driver_phone' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,maintenance,inactive',
        ]);

        $transportVehicle->update($validated);

        return redirect()->route('admin.transport-vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(TransportVehicle $transportVehicle): RedirectResponse
    {
        $transportVehicle->delete();
        return redirect()->route('admin.transport-vehicles.index')
            ->with('success', 'Vehicle deleted.');
    }
}
