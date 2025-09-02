<?php

namespace App\Exceptions;

use App\Utilities\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class InvalidCredentialException extends Exception
{
    public function render(): JsonResponse
    {
        return ApiResponse::notFound('Invalid credentials');
    }
}

