<?php

namespace App\Exceptions;

use App\Utilities\ApiResponse;
use Exception;

class UserNotFoundException extends Exception
{
    public function render(): ApiResponse
    {
        return ApiResponse::notFound('User not found');
    }
}
