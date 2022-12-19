<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Jsonify
{
    public static function jsonSuccess(string $message = 'Action Successful', $data = [],  int $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function jsonError(string $message = 'Some Error occured', $errors = [], int $code = 401): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
