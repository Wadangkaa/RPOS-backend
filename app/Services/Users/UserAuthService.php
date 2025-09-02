<?php

namespace App\Services\Users;

use App\Exceptions\InvalidCredentialException;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @throws InvalidCredentialException
     * @throws UserNotFoundException
     */
    public function login(array $request): array
    {
        $user = User::where('phone', $request['phone'])->first();

        if (!$user) {
            throw new UserNotFoundException();
        }

        if (!Hash::check($request['password'], $user->password)) {
            throw new InvalidCredentialException();
        }

        $token = $user->createToken('user-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }

    public function profile(): User
    {
        return Auth::guard('admin')->user();
    }

    public function logout(): void
    {
        Auth::guard('admin')->logout();
    }
}
