<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
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

        Asset::create($validated);

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

        AssetCategory::create($validated);

        return back()->with('success', 'Asset category added.');
    }
}
