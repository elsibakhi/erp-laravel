<?php

namespace App\Domains\Authentication\Controllers;

use App\Domains\Authentication\Requests\LoginRequest;
use App\Domains\Authentication\Requests\RegisterRequest;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\LandlordUser;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    // public function register(RegisterRequest $request)
    // {

    //     $request->routeIs('register.base') ? DB::setDefaultConnection('landlord') : DB::setDefaultConnection('tenant');

    //     $requestData = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //     ];
    //     $user = $request->routeIs('register.base') ?
    //     LandlordUser::create($requestData) :
    //     TenantUser::create($requestData);

    //     $data = [
    //         'token' => $user->createToken('auth_token')->plainTextToken,
    //     ];

    //     return ApiResponse::success(
    //         $data,
    //         'User created successfully',
    //         201
    //     );
    // }

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');
        // Choose model dynamically
        $userModel = $request->routeIs('login.base') ? LandlordUser::class : TenantUser::class;

        // Find the user
        $user = $userModel::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user->tokens()->delete();

        $data = [
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];

        return ApiResponse::success(
            $data,
            'Login successful',
            200
        );
    }
}
