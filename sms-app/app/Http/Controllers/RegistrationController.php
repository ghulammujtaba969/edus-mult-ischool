<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Campus;
use App\Models\Domain;
use App\Models\Plan;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        $plans = Plan::where('is_active', true)->get();
        return view('auth.register-school', compact('plans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:schools,slug|alpha_dash',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
            'plan_id' => 'required|exists:plans,id',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create School
            $school = School::create([
                'name' => $validated['school_name'],
                'slug' => $validated['slug'],
                'plan_id' => $validated['plan_id'],
                'status' => 'active',
                'trial_ends_at' => now()->addDays(14), // 14-day trial
            ]);

            // 2. Create Initial Branch (Campus)
            $campus = Campus::create([
                'school_id' => $school->id,
                'name' => 'Main Campus',
                'code' => strtoupper(substr($validated['slug'], 0, 3)) . '-01',
                'is_active' => true,
            ]);

            // 3. Create Admin User
            $user = User::create([
                'school_id' => $school->id,
                'campus_id' => $campus->id,
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['admin_password']),
                'role' => UserRole::CAMPUS_ADMIN,
                'is_active' => true,
            ]);

            // 4. Create Subdomain
            Domain::create([
                'school_id' => $school->id,
                'domain' => $validated['slug'] . '.' . parse_url(config('app.url'), PHP_URL_HOST),
                'type' => 'subdomain',
                'is_verified' => true,
            ]);

            DB::commit();

            auth()->login($user);

            return redirect()->route('dashboard')
                ->with('success', 'Welcome to your new School Management System!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again. ' . $e->getMessage());
        }
    }
}
