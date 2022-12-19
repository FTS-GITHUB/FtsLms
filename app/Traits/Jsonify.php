<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Jsonify
{
    public static function jsonSuccess($data = [] , string $message = 'Action Successful', $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'OK',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function jsonError($errors = [], $message = 'error', $status = 401): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
