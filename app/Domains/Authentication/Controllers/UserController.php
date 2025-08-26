<?php

namespace App\Domains\Authentication\Controllers;

use App\Domains\Authentication\Requests\AssignRoleRequest;
use App\Domains\Authentication\Requests\StoreUserRequest;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\LandlordUser;
use App\Models\TenantUser;
use App\Traits\TenantGuard;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use TenantGuard;

    public function store(StoreUserRequest $request)
    {

        authorizePermission('store users', $this->getGuard());

        $requestData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];
        $data = DB::transaction(function () use ($requestData, $request, &$user) {

            $user = $request->role == 'Super Admin' ?
            LandlordUser::create($requestData) :
            TenantUser::create($requestData);

            $user->assignRole($request->role ?? erpDefaultRole());

            return [
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];

        });

        return ApiResponse::success(
            $data,
            'User created successfully',
            201
        );
    }

    public function assignRole(AssignRoleRequest $request, TenantUser $user)
    {

        authorizePermission('assign roles to users', $this->getGuard());
        $user->syncRoles($request->role);

        return ApiResponse::success(
            null,
            'Role assigned successfully',
            200
        );
    }

    public function destroy(TenantUser $user)
    {
        authorizePermission('destroy users', $this->getGuard());
        $user->delete();

        return ApiResponse::success(
            null,
            'User deleted successfully',
            200
        );
    }
}
