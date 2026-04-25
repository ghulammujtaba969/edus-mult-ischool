<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index(): View
    {
        $permissions = Permission::orderBy('module')->orderBy('name')->get()->groupBy('module');
        return view('super-admin.permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        return view('super-admin.permissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Permission::create($validated);

        return redirect()->route('super-admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission): View
    {
        return view('super-admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $permission->update($validated);

        return redirect()->route('super-admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        return redirect()->route('super-admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
