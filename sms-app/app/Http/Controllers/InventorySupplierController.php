<?php

namespace App\Http\Controllers;

use App\Models\InventorySupplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventorySupplierController extends Controller
{
    public function index(): View
    {
        $suppliers = InventorySupplier::latest()->get();
        return view('inventory.suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('inventory.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        InventorySupplier::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
        ]));

        return redirect()->route('admin.inventory-suppliers.index')
            ->with('success', 'Supplier added.');
    }
}
