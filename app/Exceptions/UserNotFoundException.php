<?php

namespace App\Exceptions;

use App\Utilities\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class UserNotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return ApiResponse::notFound('User not found');
    }
}
