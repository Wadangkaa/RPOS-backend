<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserLoginRequest;
use App\Services\Users\UserAuthService;
use App\Utilities\ApiResponse;

class UserAuthController extends Controller
{
    public function __construct(protected UserAuthService $authService)
    {
        //
    }

    public function login(UserLoginRequest $request)
    {
        $validatedData = $request->validated();
        $data = $this->authService->login($validatedData);
        return ApiResponse::success($data, 'Login successful');
    }

    public function logout()
    {
        $this->authService->logout();
        return ApiResponse::success(null, 'Logout successful');
    }

    public function profile()
    {
        $data = $this->authService->profile();
        return ApiResponse::success($data, 'Profile');
    }
}
