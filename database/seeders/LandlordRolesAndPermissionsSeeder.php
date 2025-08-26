<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder for adding roles and permissions.
 *
 * @phpstan-type Role array{name: string, guard_name: string}
 * @phpstan-type Permission array{name: string, guard_name: string}
 */
class LandlordRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example roles and permissions. Replace with your actual data.
        $guardName = 'landlord-api';
        $roles = erpLandlordRoles()->toArray();

        $permissions = erpLandlordPermissions()->toArray();

        // Insert roles

        foreach ($roles as $roleName) {
            DB::table('roles')->updateOrInsert(
                ['name' => $roleName, 'guard_name' => $guardName],
                []
            );
        }

        // Insert permissions

        foreach ($permissions as $permissionName) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permissionName, 'guard_name' => $guardName],
                []
            );
        }

        // Assign permissions to roles
        $rolePermissions = erpLandlordRolesHasPermissions()->toArray();

        foreach ($rolePermissions as $roleName => $permissionNames) {
            $role = DB::table('roles')->where('name', $roleName)->first();
            foreach ($permissionNames as $permissionName) {
                $permission = DB::table('permissions')->where('name', $permissionName)->first();
                if ($role && $permission) {
                    DB::table('role_has_permissions')->updateOrInsert([
                        'role_id' => $role->id,
                        'permission_id' => $permission->id,
                    ], []);
                }
            }
        }
    }
}
