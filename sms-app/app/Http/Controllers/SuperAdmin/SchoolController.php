<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Plan;
use App\Models\Domain;
use App\Models\User;
use App\Models\Campus;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function index(Request $request): View
    {
        $query = School::with(['plan', 'primaryDomain'])->withCount('branches');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        $schools = $query->latest()->paginate(10)->withQueryString();
        $plans = Plan::where('is_active', true)->get();

        return view('super-admin.schools.index', compact('schools', 'plans'));
    }

    public function create(): View
    {
        $plans = Plan::where('is_active', true)->get();
        return view('super-admin.schools.create', compact('plans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:schools,slug',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:pending,active,suspended',
            'campus_name' => 'required|string|max:255',
            'campus_code' => 'required|string|max:255|unique:campuses,code',
            'campus_city' => 'nullable|string|max:255',
            'campus_phone' => 'nullable|string|max:20',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $school = School::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'plan_id' => $validated['plan_id'],
                'status' => $validated['status'],
            ]);

            // Create default subdomain
            Domain::create([
                'school_id' => $school->id,
                'domain' => $validated['slug'] . '.' . config('app.url_base', 'localhost'),
                'type' => 'subdomain',
                'is_verified' => true,
            ]);

            // Create main campus
            $campus = Campus::create([
                'school_id' => $school->id,
                'name' => $validated['campus_name'],
                'code' => $validated['campus_code'],
                'city' => $validated['campus_city'],
                'phone' => $validated['campus_phone'],
                'is_active' => true,
            ]);

            // Create primary admin user
            User::create([
                'school_id' => $school->id,
                'campus_id' => $campus->id,
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['admin_password']),
                'role' => UserRole::CAMPUS_ADMIN,
                'is_active' => true,
            ]);

            DB::commit();

            return redirect()->route('super-admin.schools.index')
                ->with('success', 'School, main campus, and administrator account created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create school: ' . $e->getMessage());
        }
    }

    public function edit(School $school): View
    {
        $plans = Plan::where('is_active', true)->get();
        return view('super-admin.schools.edit', compact('school', 'plans'));
    }

    public function update(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:pending,active,suspended',
        ]);

        $school->update($validated);

        return redirect()->route('super-admin.schools.index')
            ->with('success', 'School updated successfully.');
    }

    public function impersonate(School $school): RedirectResponse
    {
        $admin = $school->users()->where('role', UserRole::CAMPUS_ADMIN)->first();

        if (! $admin) {
            return redirect()->route('super-admin.users.create', [
                'school_id' => $school->id,
                'role' => UserRole::CAMPUS_ADMIN->value
            ])->with('error', 'No administrator found for this school. Please create one first.');
        }

        // Store current user ID to allow returning back to super admin later if needed
        session()->put('impersonator_id', auth()->id());

        auth()->login($admin);

        return redirect()->route('admin.dashboard')
            ->with('success', "Now logged in as Admin for {$school->name}");
    }

    public function leaveImpersonation(): RedirectResponse
    {
        $impersonatorId = session()->pull('impersonator_id');

        if (! $impersonatorId) {
            return redirect()->route('login');
        }

        $superAdmin = \App\Models\User::find($impersonatorId);

        if (! $superAdmin) {
            return redirect()->route('login');
        }

        auth()->login($superAdmin);

        return redirect()->route('super-admin.dashboard')
            ->with('success', 'Returned to Super Admin portal.');
    }
}
