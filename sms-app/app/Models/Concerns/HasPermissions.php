<?php

namespace App\Models\Concerns;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(string $permission): bool
    {
        // Super Admin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->getAllPermissions()->contains('slug', $permission);
    }

    public function hasRole(...$roles): bool
    {
        if (isset($roles[0]) && is_array($roles[0])) {
            $roles = $roles[0];
        }

        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }

        return false;
    }

    public function getAllPermissions()
    {
        return Cache::rememberForever("user_{$this->id}_permissions", function () {
            // Permissions from roles
            $rolePermissions = $this->roles()->with('permissions')->get()
                ->pluck('permissions')->flatten();

            // Direct permissions
            $directPermissions = $this->permissions()->get();

            return $rolePermissions->merge($directPermissions)->unique('id');
        });
    }

    public function clearPermissionCache(): void
    {
        Cache::forget("user_{$this->id}_permissions");
    }

    public function assignRole(...$roles): void
    {
        $roles = $this->getAllRoleModels($roles);
        if ($roles->isEmpty()) {
            return;
        }

        $this->roles()->syncWithoutDetaching($roles);
        $this->clearPermissionCache();
    }

    public function removeRole(...$roles): void
    {
        $roles = $this->getAllRoleModels($roles);
        $this->roles()->detach($roles);
        $this->clearPermissionCache();
    }

    public function syncRoles(...$roles): void
    {
        $roles = $this->getAllRoleModels($roles);
        $this->roles()->sync($roles);
        $this->clearPermissionCache();
    }

    protected function getAllRoleModels(array $roles)
    {
        if (isset($roles[0]) && is_array($roles[0])) {
            $roles = $roles[0];
        }

        return Role::whereIn('slug', $roles)->get();
    }

    public function givePermissionTo(...$permissions): void
    {
        $permissions = $this->getAllPermissionModels($permissions);
        if ($permissions->isEmpty()) {
            return;
        }

        $this->permissions()->syncWithoutDetaching($permissions);
        $this->clearPermissionCache();
    }

    public function withdrawPermissionTo(...$permissions): void
    {
        $permissions = $this->getAllPermissionModels($permissions);
        $this->permissions()->detach($permissions);
        $this->clearPermissionCache();
    }

    public function syncPermissions(...$permissions): void
    {
        $permissions = $this->getAllPermissionModels($permissions);
        $this->permissions()->sync($permissions);
        $this->clearPermissionCache();
    }

    protected function getAllPermissionModels(array $permissions)
    {
        if (isset($permissions[0]) && is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        return Permission::whereIn('slug', $permissions)->get();
    }
}
