<?php

if (! function_exists('erpLandlordRoles')) {
    function erpLandlordRoles()
    {
        return collect(config('roles_permissions.roles.landlord-api'));
    }
}

if (! function_exists('erpLandlordPermissions')) {
    function erpLandlordPermissions()
    {
        return collect(config('roles_permissions.permissions.landlord-api'));
    }
}
if (! function_exists('erpLandlordRolesHasPermissions')) {
    function erpLandlordRolesHasPermissions()
    {
        return collect(config('roles_permissions.roles-has-permissions.landlord-api'));
    }
}
if (! function_exists('erpTenantRoles')) {
    function erpTenantRoles()
    {
        return collect(config('roles_permissions.roles.tenant-api'));
    }
}

if (! function_exists('erpTenantPermissions')) {
    function erpTenantPermissions()
    {
        return collect(config('roles_permissions.permissions.tenant-api'));
    }
}

if (! function_exists('erpTenantRolesHasPermissions')) {
    function erpTenantRolesHasPermissions()
    {
        return collect(config('roles_permissions.roles-has-permissions.tenant-api'));
    }
}

if (! function_exists('erpDefaultRole')) {
    function erpDefaultRole()
    {
        return collect(config('roles_permissions.default_role'));
    }
}
if (! function_exists('authorizePermission')) {
    function authorizePermission(string $permission, string $guard_name): void
    {
        $user = auth()->guard($guard_name)->user();

        if (! $user || ! $user->hasPermissionTo($permission, $guard_name)) {
            abort(403, 'Forbidden');
        }
    }
}
