<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Campus;
use App\Services\CampusManager;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function index(): View
    {
        $assets = Asset::with('category')->latest()->get();
        $categories = AssetCategory::withCount('assets')->get();
        return view('assets.index', compact('assets', 'categories'));
    }

    public function create(): View
    {
        $categories = AssetCategory::all();
        return view('assets.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'asset_category_id' => 'required|exists:asset_categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:assets,code',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'required|numeric|min:0',
            'condition' => 'required|string|in:new,used,broken',
            'status' => 'required|string|in:available,in_use,disposed',
        ]);

        $tenant = $this->tenantPayload($request);
        if (! $tenant['campus_id']) {
            return back()->withInput()->with('error', 'Please select an active campus before recording an asset.');
        }

        Asset::create(array_merge($validated, $tenant));

        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset recorded successfully.');
    }

    public function show(Asset $asset): View
    {
        $asset->load(['category', 'assignments.assignedTo']);
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset): View
    {
        $categories = AssetCategory::all();
        return view('assets.edit', compact('asset', 'categories'));
    }

    public function update(Request $request, Asset $asset): RedirectResponse
    {
        $validated = $request->validate([
            'asset_category_id' => 'required|exists:asset_categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:assets,code,' . $asset->id,
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'required|numeric|min:0',
            'condition' => 'required|string|in:new,used,broken',
            'status' => 'required|string|in:available,in_use,disposed',
        ]);

        $asset->update($validated);

        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset): RedirectResponse
    {
        $asset->delete();
        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset deleted successfully.');
    }

    // Category Management
    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tenant = $this->tenantPayload($request);
        if (! $tenant['campus_id']) {
            return back()->withInput()->with('error', 'Please select an active campus before adding an asset category.');
        }

        AssetCategory::create(array_merge($validated, $tenant));

        return back()->with('success', 'Asset category added.');
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
