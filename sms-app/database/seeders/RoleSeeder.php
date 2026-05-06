<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Roles from UserRole enum
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => UserRole::SUPER_ADMIN->value,
                'description' => 'Platform level administrator with full access',
            ],
            [
                'name' => 'Campus Admin',
                'slug' => UserRole::CAMPUS_ADMIN->value,
                'description' => 'Administrator for a specific campus',
            ],
            [
                'name' => 'Principal',
                'slug' => UserRole::PRINCIPAL->value,
                'description' => 'Academic head of the campus',
            ],
            [
                'name' => 'Teacher',
                'slug' => UserRole::TEACHER->value,
                'description' => 'Academic staff member',
            ],
            [
                'name' => 'Accountant',
                'slug' => UserRole::ACCOUNTANT->value,
                'description' => 'Financial staff member',
            ],
            [
                'name' => 'Parent',
                'slug' => UserRole::PARENT->value,
                'description' => 'Parent or guardian of a student',
            ],
            [
                'name' => 'Student',
                'slug' => UserRole::STUDENT->value,
                'description' => 'Student enrolled in the campus',
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::updateOrCreate(['slug' => $roleData['slug']], $roleData);

            // 2. Assign Permissions based on role
            $this->assignPermissionsToRole($role);
        }
    }

    protected function assignPermissionsToRole(Role $role): void
    {
        $permissions = [];

        switch ($role->slug) {
            case UserRole::SUPER_ADMIN->value:
                // Super admin usually gets all permissions, but the HasPermissions trait 
                // already handles this by returning true in hasPermission().
                // We can still assign them for clarity.
                $permissions = Permission::all();
                break;

            case UserRole::CAMPUS_ADMIN->value:
                $permissions = Permission::whereIn('module', ['Campuses', 'Users', 'Academics', 'Finance'])->get();
                break;

            case UserRole::PRINCIPAL->value:
                $permissions = Permission::whereIn('module', ['Users', 'Academics'])->get();
                break;

            case UserRole::TEACHER->value:
                $permissions = Permission::whereIn('slug', [
                    'view-users',
                    'manage-classes',
                    'manage-subjects',
                    'manage-students'
                ])->get();
                break;

            case UserRole::ACCOUNTANT->value:
                $permissions = Permission::whereIn('module', ['Finance'])->get();
                break;

            case UserRole::PARENT->value:
            case UserRole::STUDENT->value:
                $permissions = Permission::whereIn('slug', [
                    'view-fees'
                ])->get();
                break;
        }

        if (!empty($permissions)) {
            $role->permissions()->sync($permissions);
        }
    }
}
