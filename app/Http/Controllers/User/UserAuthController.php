<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Users\UserAuthService;

class UserAuthController extends Controller
{
    public function __construct(protected UserAuthService $authService)
    {
        //
    }

    public function login($request)
    {
        $data = $this->authService->login($request);
        return response()->json($data);
    }

    public function logout()
    {
        $this->authService->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function profile()
    {
        $data = $this->authService->profile();
        return response()->json($data);
    }
}
