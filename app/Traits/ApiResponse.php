<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data = null, $message = '', $code = 200, $next = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'next' => $next,
        ], $code);
    }

    protected function errorResponse($message = '', $errors = null, $code = 400, $next = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'next' => $next,
        ], $code);
    }
}
