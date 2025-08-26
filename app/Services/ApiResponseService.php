<?php

namespace App\Services;

class ApiResponseService
{
    public function success($data = null, $message = '', $code = 200, $next = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'next' => $next,
        ], $code);
    }

    public function error($message = '', $errors = null, $code = 400, $next = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'next' => $next,
        ], $code);
    }
}
