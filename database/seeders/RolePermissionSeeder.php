<?php

namespace Database\Seeders;

use App\Enums\PermissionName;
use App\Enums\RoleName;
use App\Support\PermissionsMatrix;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (PermissionName::values() as $permission) {
            Permission::query()->firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        foreach (RoleName::values() as $role) {
            Role::query()->firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        foreach (PermissionsMatrix::rolePermissions() as $roleName => $permissions) {
            $permissionModels = collect($permissions)
                ->map(fn (PermissionName $p) => Permission::query()->where('name', $p->value)->first())
                ->filter()
                ->values()
                ->all();

            Role::query()->where('name', $roleName)->first()?->syncPermissions($permissionModels);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
