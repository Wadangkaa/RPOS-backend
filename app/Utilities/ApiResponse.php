<?php

namespace App\Utilities;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'Success'): JsonResponse
    {
        if ($data instanceof ResourceCollection) {
            $data = $data->response()->getData(true);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    public static function created(mixed $data = null, string $message = 'Created successfully'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], 201);
    }

    public static function error(string $message = 'Something went wrong', int $code = 500, mixed $data = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function validationError(mixed $errors = null, string $message = 'Validation failed'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    public static function notFound(string $message = 'Data not found'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 404);
    }
}
