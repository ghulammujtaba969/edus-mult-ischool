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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SchoolController extends Controller
{
    public function index(Request $request): View
    {
        $query = School::with(['plan', 'primaryDomain', 'domains'])
            ->withCount([
                'branches',
                'users',
                'users as students_count' => function ($q) {
                    $q->where('role', UserRole::STUDENT->value);
                },
            ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'trial') {
                $query->whereNotNull('trial_ends_at')->where('trial_ends_at', '>', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        if ($request->filled('students_min')) {
            $query->whereHas('users', fn ($q) => $q->where('role', UserRole::STUDENT->value), '>=', (int) $request->students_min);
        }

        if ($request->filled('students_max')) {
            $query->whereHas('users', fn ($q) => $q->where('role', UserRole::STUDENT->value), '<=', (int) $request->students_max);
        }

        if ($request->filled('mrr_min')) {
            $query->whereHas('plan', fn ($q) => $q->where('monthly_price', '>=', (float) $request->mrr_min));
        }

        if ($request->filled('mrr_max')) {
            $query->whereHas('plan', fn ($q) => $q->where('monthly_price', '<=', (float) $request->mrr_max));
        }

        if ($request->filled('registered_from')) {
            $query->whereDate('created_at', '>=', $request->registered_from);
        }

        if ($request->filled('registered_to')) {
            $query->whereDate('created_at', '<=', $request->registered_to);
        }

        if ($request->filled('domain_status')) {
            match ($request->domain_status) {
                'verified' => $query->whereHas('domains', fn ($q) => $q->where('is_verified', true)),
                'pending' => $query->whereHas('domains', fn ($q) => $q->where('is_verified', false)),
                'none' => $query->doesntHave('domains'),
                default => null,
            };
        }

        $storagePercentSql = '((schools.id * 13) % 89) + 8';

        if ($request->filled('storage_min')) {
            $query->whereRaw("{$storagePercentSql} >= ?", [(int) $request->storage_min]);
        }

        if ($request->filled('storage_max')) {
            $query->whereRaw("{$storagePercentSql} <= ?", [(int) $request->storage_max]);
        }

        $matchingCount = (clone $query)->count();

        match ($request->get('sort', 'newest')) {
            'oldest' => $query->oldest(),
            'name_asc' => $query->orderBy('name'),
            'mrr_desc' => $query->join('plans as sort_plans', 'schools.plan_id', '=', 'sort_plans.id')
                ->orderByDesc('sort_plans.monthly_price')
                ->select('schools.*'),
            'students_desc' => $query->orderByDesc('students_count'),
            default => $query->latest(),
        };

        $schools = $query->paginate(10)->withQueryString();
        $plans = Plan::where('is_active', true)->get();
        $statusStats = [
            'active' => School::where('status', 'active')->count(),
            'trial' => School::whereNotNull('trial_ends_at')->where('trial_ends_at', '>', now())->count(),
            'suspended' => School::where('status', 'suspended')->count(),
            'total' => School::count(),
        ];

        return view('super-admin.schools.index', compact('schools', 'plans', 'statusStats', 'matchingCount'));
    }

    public function create(): View
    {
        $plans = Plan::where('is_active', true)->get();
        $accountManagers = User::where('role', UserRole::SUPER_ADMIN->value)
            ->orderBy('name')
            ->get();

        return view('super-admin.schools.create', compact('plans', 'accountManagers'));
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('registration_number')) {
            $registrationNumber = Str::startsWith($request->registration_number, 'SCH-')
                ? $request->registration_number
                : 'SCH-' . $request->registration_number;

            $request->merge(['registration_number' => $registrationNumber]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'slug' => 'required|string|max:255|unique:schools,slug',
            'registration_number' => 'nullable|string|max:80|unique:schools,registration_number',
            'established_year' => 'nullable|integer|min:1800|max:' . now()->year,
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string|max:2000',
            'country' => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'official_email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'website' => 'nullable|string|max:255',
            'custom_subdomain' => 'nullable|string|max:100|alpha_dash',
            'whatsapp' => 'nullable|string|max:30',
            'twitter' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:255',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:pending,active,suspended',
            'billing_cycle' => 'required|in:monthly,quarterly,annual',
            'trial_days' => 'nullable|integer|in:0,7,14,30',
            'max_students' => 'nullable|integer|min:0',
            'max_teachers' => 'nullable|integer|min:0',
            'storage_gb' => 'nullable|integer|min:0',
            'custom_mrr' => 'nullable|numeric|min:0',
            'tags' => 'nullable|string|max:500',
            'features' => 'nullable|array',
            'features.*' => 'boolean',
            'internal_notes' => 'nullable|string|max:3000',
            'account_manager_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn ($q) => $q->where('role', UserRole::SUPER_ADMIN->value)),
            ],
            'campus_name' => 'required|string|max:255',
            'campus_code' => 'required|string|max:255|unique:campuses,code',
            'campus_city' => 'nullable|string|max:255',
            'campus_phone' => 'nullable|string|max:20',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        $trialDays = (int) ($validated['trial_days'] ?? 0);
        $customSubdomain = $validated['custom_subdomain'] ?? $validated['slug'];
        $domainName = $customSubdomain . '.' . config('app.url_base', 'localhost');

        if (Domain::where('domain', $domainName)->exists()) {
            return back()
                ->withInput()
                ->with('error', 'The custom subdomain is already in use.');
        }

        $logoPath = null;

        try {
            DB::beginTransaction();

            $logoPath = $request->hasFile('logo')
                ? $request->file('logo')->store('school-logos', 'public')
                : null;

            $school = School::create([
                'name' => $validated['name'],
                'short_name' => $validated['short_name'] ?? null,
                'slug' => $validated['slug'],
                'registration_number' => $validated['registration_number'] ?: null,
                'established_year' => $validated['established_year'] ?? null,
                'logo' => $logoPath,
                'description' => $validated['description'] ?? null,
                'country' => $validated['country'],
                'province' => $validated['province'] ?? null,
                'city' => $validated['campus_city'] ?? null,
                'address' => $validated['address'] ?? null,
                'official_email' => $validated['official_email'],
                'phone' => $validated['phone'] ?? $validated['campus_phone'] ?? null,
                'website' => $validated['website'] ?? null,
                'custom_subdomain' => $customSubdomain,
                'whatsapp' => $validated['whatsapp'] ?? null,
                'twitter' => $validated['twitter'] ?? null,
                'facebook' => $validated['facebook'] ?? null,
                'plan_id' => $validated['plan_id'],
                'status' => $validated['status'],
                'trial_ends_at' => $trialDays > 0 ? now()->addDays($trialDays) : null,
                'billing_cycle' => $validated['billing_cycle'],
                'trial_days' => $trialDays,
                'max_students' => $validated['max_students'] ?? null,
                'max_teachers' => $validated['max_teachers'] ?? null,
                'storage_gb' => $validated['storage_gb'] ?? null,
                'custom_mrr' => $validated['custom_mrr'] ?? null,
                'tags' => collect(explode(',', $validated['tags'] ?? ''))
                    ->map(fn ($tag) => trim($tag))
                    ->filter()
                    ->values()
                    ->all(),
                'feature_toggles' => collect($validated['features'] ?? [])->map(fn ($enabled) => (bool) $enabled)->all(),
                'internal_notes' => $validated['internal_notes'] ?? null,
                'account_manager_id' => $validated['account_manager_id'] ?? null,
            ]);

            if (empty($school->registration_number)) {
                $school->update([
                    'registration_number' => 'SCH-' . str_pad((string) $school->id, 5, '0', STR_PAD_LEFT),
                ]);
            }

            // Create default subdomain
            Domain::create([
                'school_id' => $school->id,
                'domain' => $domainName,
                'type' => 'subdomain',
                'is_verified' => true,
            ]);

            // Create main campus
            $campus = Campus::create([
                'school_id' => $school->id,
                'name' => $validated['campus_name'],
                'code' => $validated['campus_code'],
                'city' => $validated['campus_city'],
                'phone' => $validated['campus_phone'] ?? $validated['phone'] ?? null,
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
            if (! empty($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            return back()->withInput()->with('error', 'Failed to create school: ' . $e->getMessage());
        }
    }

    public function edit(School $school): View
    {
        $plans = Plan::where('is_active', true)->get();
        $school->load(['branches', 'users', 'primaryDomain', 'domains']);
        $mainCampus = $school->branches()->oldest()->first();
        $schoolAdmin = $school->users()->where('role', UserRole::CAMPUS_ADMIN)->oldest()->first();
        $accountManagers = User::where('role', UserRole::SUPER_ADMIN->value)
            ->orderBy('name')
            ->get();

        return view('super-admin.schools.edit', compact('school', 'plans', 'mainCampus', 'schoolAdmin', 'accountManagers'));
    }

    public function update(Request $request, School $school): RedirectResponse
    {
        if ($request->filled('registration_number')) {
            $registrationNumber = Str::startsWith($request->registration_number, 'SCH-')
                ? $request->registration_number
                : 'SCH-' . $request->registration_number;

            $request->merge(['registration_number' => $registrationNumber]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'registration_number' => [
                'nullable',
                'string',
                'max:80',
                Rule::unique('schools', 'registration_number')->ignore($school->id),
            ],
            'established_year' => 'nullable|integer|min:1800|max:' . now()->year,
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string|max:2000',
            'country' => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'official_email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'website' => 'nullable|string|max:255',
            'custom_subdomain' => 'nullable|string|max:100|alpha_dash',
            'whatsapp' => 'nullable|string|max:30',
            'twitter' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:255',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:pending,active,suspended',
            'billing_cycle' => 'required|in:monthly,quarterly,annual',
            'trial_days' => 'nullable|integer|in:0,7,14,30',
            'max_students' => 'nullable|integer|min:0',
            'max_teachers' => 'nullable|integer|min:0',
            'storage_gb' => 'nullable|integer|min:0',
            'custom_mrr' => 'nullable|numeric|min:0',
            'tags' => 'nullable|string|max:500',
            'features' => 'nullable|array',
            'features.*' => 'boolean',
            'internal_notes' => 'nullable|string|max:3000',
            'account_manager_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn ($q) => $q->where('role', UserRole::SUPER_ADMIN->value)),
            ],
            'campus_name' => 'required|string|max:255',
            'campus_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('campuses', 'code')->ignore($school->branches()->oldest()->value('id')),
            ],
            'campus_city' => 'nullable|string|max:255',
            'campus_phone' => 'nullable|string|max:20',
            'admin_name' => 'nullable|string|max:255',
            'admin_email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($school->users()->where('role', UserRole::CAMPUS_ADMIN)->oldest()->value('id')),
            ],
            'admin_password' => 'nullable|string|min:8|confirmed',
        ]);

        $trialDays = (int) ($validated['trial_days'] ?? 0);
        $customSubdomain = $validated['custom_subdomain'] ?? $school->slug;
        $domainName = $customSubdomain . '.' . config('app.url_base', 'localhost');
        $primaryDomain = $school->primaryDomain;

        if (Domain::where('domain', $domainName)
            ->when($primaryDomain, fn ($q) => $q->where('id', '!=', $primaryDomain->id))
            ->exists()) {
            return back()
                ->withInput()
                ->with('error', 'The custom subdomain is already in use.');
        }

        $newLogoPath = null;

        try {
            DB::beginTransaction();

            $newLogoPath = $request->hasFile('logo')
                ? $request->file('logo')->store('school-logos', 'public')
                : null;

            $oldLogoPath = $school->logo;

            $school->update([
                'name' => $validated['name'],
                'short_name' => $validated['short_name'] ?? null,
                'registration_number' => $validated['registration_number'] ?: $school->registration_number,
                'established_year' => $validated['established_year'] ?? null,
                'logo' => $newLogoPath ?: $school->logo,
                'description' => $validated['description'] ?? null,
                'country' => $validated['country'],
                'province' => $validated['province'] ?? null,
                'city' => $validated['campus_city'] ?? null,
                'address' => $validated['address'] ?? null,
                'official_email' => $validated['official_email'],
                'phone' => $validated['phone'] ?? $validated['campus_phone'] ?? null,
                'website' => $validated['website'] ?? null,
                'custom_subdomain' => $customSubdomain,
                'whatsapp' => $validated['whatsapp'] ?? null,
                'twitter' => $validated['twitter'] ?? null,
                'facebook' => $validated['facebook'] ?? null,
                'plan_id' => $validated['plan_id'],
                'status' => $validated['status'],
                'trial_ends_at' => $trialDays > 0 ? now()->addDays($trialDays) : null,
                'billing_cycle' => $validated['billing_cycle'],
                'trial_days' => $trialDays,
                'max_students' => $validated['max_students'] ?? null,
                'max_teachers' => $validated['max_teachers'] ?? null,
                'storage_gb' => $validated['storage_gb'] ?? null,
                'custom_mrr' => $validated['custom_mrr'] ?? null,
                'tags' => collect(explode(',', $validated['tags'] ?? ''))
                    ->map(fn ($tag) => trim($tag))
                    ->filter()
                    ->values()
                    ->all(),
                'feature_toggles' => collect($validated['features'] ?? [])->map(fn ($enabled) => (bool) $enabled)->all(),
                'internal_notes' => $validated['internal_notes'] ?? null,
                'account_manager_id' => $validated['account_manager_id'] ?? null,
            ]);

            if ($newLogoPath && $oldLogoPath) {
                Storage::disk('public')->delete($oldLogoPath);
            }

            if ($primaryDomain) {
                $primaryDomain->update([
                    'domain' => $domainName,
                    'is_verified' => true,
                ]);
            } else {
                Domain::create([
                    'school_id' => $school->id,
                    'domain' => $domainName,
                    'type' => 'subdomain',
                    'is_verified' => true,
                ]);
            }

            $campus = $school->branches()->oldest()->first();
            if ($campus) {
                $campus->update([
                    'name' => $validated['campus_name'],
                    'code' => $validated['campus_code'],
                    'city' => $validated['campus_city'] ?? null,
                    'phone' => $validated['campus_phone'] ?? $validated['phone'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'email' => $validated['official_email'],
                ]);
            } else {
                Campus::create([
                    'school_id' => $school->id,
                    'name' => $validated['campus_name'],
                    'code' => $validated['campus_code'],
                    'city' => $validated['campus_city'] ?? null,
                    'phone' => $validated['campus_phone'] ?? $validated['phone'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'email' => $validated['official_email'],
                    'is_active' => true,
                ]);
            }

            $admin = $school->users()->where('role', UserRole::CAMPUS_ADMIN)->oldest()->first();
            if ($admin && ($validated['admin_name'] ?? null || $validated['admin_email'] ?? null || $request->filled('admin_password'))) {
                $adminData = [
                    'name' => $validated['admin_name'] ?: $admin->name,
                    'email' => $validated['admin_email'] ?: $admin->email,
                ];

                if ($request->filled('admin_password')) {
                    $adminData['password'] = Hash::make($validated['admin_password']);
                }

                $admin->update($adminData);
            }

            DB::commit();

            return redirect()->route('super-admin.schools.edit', $school)
                ->with('success', 'School updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (! empty($newLogoPath)) {
                Storage::disk('public')->delete($newLogoPath);
            }

            return back()->withInput()->with('error', 'Failed to update school: ' . $e->getMessage());
        }
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
