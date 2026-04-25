<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::withoutGlobalScope('school')
            ->whereNull('school_id')
            ->orderBy('name')
            ->get();
        return view('super-admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::orderBy('module')->orderBy('name')->get()->groupBy('module');
        return view('super-admin.roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'school_id' => null, // Global roles for Super Admin
        ]);

        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return redirect()->route('super-admin.roles.index')
            ->with('success', 'Global role created successfully.');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::orderBy('module')->orderBy('name')->get()->groupBy('module');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('super-admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('super-admin.roles.index')
            ->with('success', 'Global role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return redirect()->route('super-admin.roles.index')
            ->with('success', 'Global role deleted successfully.');
    }
}
