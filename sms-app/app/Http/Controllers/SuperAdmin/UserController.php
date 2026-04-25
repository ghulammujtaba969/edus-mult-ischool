<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Enums\UserRole;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;

class UserController extends Controller
{
    public function permissions(User $user): View
    {
        $permissions = Permission::orderBy('module')->orderBy('name')->get()->groupBy('module');
        $userPermissions = $user->permissions->pluck('id')->toArray();
        return view('super-admin.users.permissions', compact('user', 'permissions', 'userPermissions'));
    }

    public function updatePermissions(Request $request, User $user): RedirectResponse
    {
        $user->permissions()->sync($request->permissions ?? []);
        $user->clearPermissionCache();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User permissions updated successfully.');
    }

    public function index(Request $request): View
    {
        $query = User::with('school');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $schools = School::orderBy('name')->get();
        $roles = UserRole::cases();

        return view('super-admin.users.index', compact('users', 'schools', 'roles'));
    }

    public function create(Request $request): View
    {
        $schools = School::orderBy('name')->get();
        $roles = UserRole::cases();
        $selectedSchoolId = $request->school_id;
        $selectedRole = $request->role;

        return view('super-admin.users.create', compact('schools', 'roles', 'selectedSchoolId', 'selectedRole'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_id' => 'nullable|exists:schools,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', new Enum(UserRole::class)],
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $schools = School::orderBy('name')->get();
        $roles = UserRole::cases();
        return view('super-admin.users.edit', compact('user', 'schools', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'school_id' => 'nullable|exists:schools,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', new Enum(UserRole::class)],
            'is_active' => 'boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
