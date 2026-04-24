<?php

namespace App\Http\Controllers;

use App\Models\TransportAssignment;
use App\Models\TransportRoute;
use App\Models\TransportVehicle;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransportAssignmentController extends Controller
{
    public function index(): View
    {
        $assignments = TransportAssignment::with(['student.user', 'route', 'pickupPoint', 'vehicle'])->latest()->get();
        return view('transport.assignments.index', compact('assignments'));
    }

    public function create(): View
    {
        $students = Student::with('user')->get();
        $routes = TransportRoute::with('pickupPoints')->get();
        $vehicles = TransportVehicle::where('status', 'active')->get();
        return view('transport.assignments.create', compact('students', 'routes', 'vehicles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'transport_route_id' => 'required|exists:transport_routes,id',
            'transport_pickup_point_id' => 'required|exists:transport_pickup_points,id',
            'transport_vehicle_id' => 'nullable|exists:transport_vehicles,id',
            'assigned_at' => 'required|date',
        ]);

        TransportAssignment::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'status' => 'active'
        ]));

        return redirect()->route('admin.transport-assignments.index')
            ->with('success', 'Transport assigned successfully.');
    }

    public function update(Request $request, TransportAssignment $transportAssignment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:active,inactive',
            'ended_at' => 'required_if:status,inactive|nullable|date',
        ]);

        $transportAssignment->update($validated);

        return redirect()->route('admin.transport-assignments.index')
            ->with('success', 'Assignment updated.');
    }
}
