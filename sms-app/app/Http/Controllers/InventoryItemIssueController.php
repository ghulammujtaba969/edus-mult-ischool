<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryItemIssue;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InventoryItemIssueController extends Controller
{
    public function index(): View
    {
        $issues = InventoryItemIssue::with(['item', 'user'])->latest()->get();
        return view('inventory.issues.index', compact('issues'));
    }

    public function create(): View
    {
        $items = InventoryItem::where('available_quantity', '>', 0)->get();
        $users = User::all();
        return view('inventory.issues.create', compact('items', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'issued_to' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'issue_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $item = InventoryItem::findOrFail($validated['inventory_item_id']);
        if ($item->available_quantity < $validated['quantity']) {
            return back()->with('error', 'Not enough quantity available.');
        }

        DB::transaction(function () use ($validated, $item) {
            InventoryItemIssue::create(array_merge($validated, [
                'campus_id' => auth()->user()->campus_id,
                'status' => 'issued',
            ]));
            $item->decrement('available_quantity', $validated['quantity']);
        });

        return redirect()->route('admin.inventory-item-issues.index')
            ->with('success', 'Item issued successfully.');
    }

    public function update(Request $request, InventoryItemIssue $inventoryItemIssue): RedirectResponse
    {
        if ($inventoryItemIssue->status === 'returned') {
            return back()->with('error', 'Item already returned.');
        }

        DB::transaction(function () use ($inventoryItemIssue) {
            $inventoryItemIssue->update([
                'status' => 'returned',
                'return_date' => now(),
            ]);
            $inventoryItemIssue->item->increment('available_quantity', $inventoryItemIssue->quantity);
        });

        return redirect()->route('admin.inventory-item-issues.index')
            ->with('success', 'Item marked as returned.');
    }
}
