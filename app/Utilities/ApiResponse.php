<?php

namespace App\Utilities;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

class ApiResponse implements Responsable
{
    protected int $httpCode;

    protected mixed $data;

    protected string $message;

    public function __construct(
        int    $httpCode,
               $data = null,
        string $message = ''
    )
    {
        if (!(($httpCode >= 200 && $httpCode < 300) || ($httpCode >= 400 && $httpCode < 600))) {
            throw new \RuntimeException($httpCode . ' is not valid');
        }
        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->message = $message;
    }

    public function toResponse($request): JsonResponse
    {
        $payload = [
            'message' => $this->message,
        ];

        if ($this->httpCode >= 200 && $this->httpCode < 300) {
            $payload['data'] = $this->data;
        } else {
            $payload['error'] = $this->data;
        }

        return response()->json($payload, $this->httpCode);
    }

    public static function success($data, string $message = 'Data fetched successfully'): static
    {
        if ($data instanceof ResourceCollection) {
            $data = $data->response()->getData(true);
        }

        return new static(200, $data, $message);
    }

    public static function created($data, string $message = 'Resource created successfully'): static
    {
        return new static(201, $data, $message);
    }

    public static function notFound(string $message = 'Resource not found'): static
    {
        return new static(404, [], $message);
    }

    public static function badRequest(string $message = 'Bad request'): static
    {
        return new static(400, [], $message);
    }

    public static function unauthorized(string $message = 'Unauthorized'): static
    {
        return new static(401, [], $message);
    }

    public static function forbidden(string $message = 'Forbidden'): static
    {
        return new static(403, [], $message);
    }

    public static function error(string $message = 'Something went wrong', int $code = 500, $errors = []): static
    {
        return new static($code, $errors, $message);
    }

    public static function validationFailed(ValidationException $e): static
    {
        return new static(422, $e->errors(), 'Validation failed');
    }

    public static function deleted(string $message = 'Resource deleted successfully'): static
    {
        return new static(200, null, $message);
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
