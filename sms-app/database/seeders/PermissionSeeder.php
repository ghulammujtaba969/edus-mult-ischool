<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // School Management (Super Admin)
            ['name' => 'View Schools', 'slug' => 'view-schools', 'module' => 'Schools', 'description' => 'Can view list of schools'],
            ['name' => 'Create Schools', 'slug' => 'create-schools', 'module' => 'Schools', 'description' => 'Can register new schools'],
            ['name' => 'Edit Schools', 'slug' => 'edit-schools', 'module' => 'Schools', 'description' => 'Can update school details'],
            ['name' => 'Delete Schools', 'slug' => 'delete-schools', 'module' => 'Schools', 'description' => 'Can remove schools'],

            // Campus Management (School Admin)
            ['name' => 'View Campuses', 'slug' => 'view-campuses', 'module' => 'Campuses', 'description' => 'Can view school branches'],
            ['name' => 'Create Campuses', 'slug' => 'create-campuses', 'module' => 'Campuses', 'description' => 'Can add new branches'],
            ['name' => 'Edit Campuses', 'slug' => 'edit-campuses', 'module' => 'Campuses', 'description' => 'Can update branch info'],
            ['name' => 'Delete Campuses', 'slug' => 'delete-campuses', 'module' => 'Campuses', 'description' => 'Can remove branches'],

            // User Management
            ['name' => 'View Users', 'slug' => 'view-users', 'module' => 'Users', 'description' => 'Can view system users'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'module' => 'Users', 'description' => 'Can add new users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'module' => 'Users', 'description' => 'Can update user profiles'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'module' => 'Users', 'description' => 'Can remove users'],

            // Academic Management
            ['name' => 'Manage Classes', 'slug' => 'manage-classes', 'module' => 'Academics', 'description' => 'Can manage school classes'],
            ['name' => 'Manage Subjects', 'slug' => 'manage-subjects', 'module' => 'Academics', 'description' => 'Can manage curriculum subjects'],
            ['name' => 'Manage Students', 'slug' => 'manage-students', 'module' => 'Academics', 'description' => 'Can manage student records'],

            // Financial Management
            ['name' => 'View Fees', 'slug' => 'view-fees', 'module' => 'Finance', 'description' => 'Can view fee structures and payments'],
            ['name' => 'Collect Fees', 'slug' => 'collect-fees', 'module' => 'Finance', 'description' => 'Can record fee payments'],
            ['name' => 'Manage Salaries', 'slug' => 'manage-salaries', 'module' => 'Finance', 'description' => 'Can manage staff payroll'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['slug' => $permission['slug']], $permission);
        }
    }
}
