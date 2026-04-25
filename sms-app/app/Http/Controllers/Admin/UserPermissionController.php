<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserPermissionController extends Controller
{
    public function index(User $user): View
    {
        // Ensure user belongs to the same school
        if ($user->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $roles = Role::orderBy('name')->get();
        $permissions = Permission::whereNotIn('module', ['Schools', 'Plans', 'Domains'])
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        $userRoles = $user->roles->pluck('id')->toArray();
        $userPermissions = $user->permissions->pluck('id')->toArray();

        return view('admin.users.permissions', compact('user', 'roles', 'permissions', 'userRoles', 'userPermissions'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // Ensure user belongs to the same school
        if ($user->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user->roles()->sync($request->roles ?? []);
        $user->permissions()->sync($request->permissions ?? []);

        return redirect()->back()->with('success', 'User roles and permissions updated successfully.');
    }
}
