<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use App\Models\InventoryItem;
use App\Models\InventorySupplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InventoryItemController extends Controller
{
    public function index(): View
    {
        $items = InventoryItem::with('supplier')->latest()->get();
        return view('inventory.items.index', compact('items'));
    }

    public function create(): View
    {
        $categories = AssetCategory::orderBy('name')->get();
        $suppliers = InventorySupplier::all();
        return view('inventory.items.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => ['required', 'string', Rule::exists('asset_categories', 'name')],
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'unit_price' => 'required|numeric|min:0',
            'inventory_supplier_id' => 'nullable|exists:inventory_suppliers,id',
        ]);

        InventoryItem::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'available_quantity' => $validated['quantity'],
        ]));

        return redirect()->route('admin.inventory-items.index')
            ->with('success', 'Inventory item added.');
    }
}
