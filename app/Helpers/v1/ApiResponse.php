<?php

namespace App\Helpers\v1;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = [], string $message = 'success', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    public static function error(array|string $errors, int $status = 422, string $message = 'error'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
