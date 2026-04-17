<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\Employee;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetAssignmentController extends Controller
{
    public function index(): View
    {
        $assignments = AssetAssignment::with(['asset', 'assignedTo'])->latest()->get();
        return view('asset-assignments.index', compact('assignments'));
    }

    public function create(Request $request): View
    {
        $assets = Asset::where('status', 'available')->get();
        $employees = Employee::with('user')->get();
        $students = Student::with('user')->get();
        $selectedAssetId = $request->input('asset_id');

        return view('asset-assignments.create', compact('assets', 'employees', 'students', 'selectedAssetId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'assigned_to_type' => 'required|string|in:App\Models\Student,App\Models\Employee',
            'assigned_to_id' => 'required|integer',
            'assigned_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $asset = Asset::findOrFail($validated['asset_id']);
        if ($asset->status !== 'available') {
            return back()->with('error', 'Asset is not available for assignment.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $asset) {
            AssetAssignment::create(array_merge($validated, [
                'campus_id' => auth()->user()->campus_id
            ]));

            $asset->update(['status' => 'in_use']);
        });

        return redirect()->route('admin.asset-assignments.index')
            ->with('success', 'Asset assigned successfully.');
    }

    public function update(Request $request, AssetAssignment $assetAssignment): RedirectResponse
    {
        $validated = $request->validate([
            'returned_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $assetAssignment) {
            $assetAssignment->update([
                'returned_at' => $validated['returned_at'],
                'notes' => $validated['notes'],
            ]);

            $assetAssignment->asset->update(['status' => 'available']);
        });

        return redirect()->route('admin.asset-assignments.index')
            ->with('success', 'Asset returned successfully.');
    }

    public function destroy(AssetAssignment $assetAssignment): RedirectResponse
    {
        if (!$assetAssignment->returned_at) {
            $assetAssignment->asset->update(['status' => 'available']);
        }
        
        $assetAssignment->delete();
        
        return redirect()->route('admin.asset-assignments.index')
            ->with('success', 'Assignment record deleted.');
    }
}
