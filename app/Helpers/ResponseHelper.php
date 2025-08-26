<?php

if (! function_exists('erpSuccessResponse')) {
    function erpSuccessResponse($data = null, $message = '', $code = 200, $next = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'next' => $next,
        ], $code);
    }
}

if (! function_exists('erpErrorResponse')) {
    function erpErrorResponse($message = '', $errors = null, $code = 400, $next = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'next' => $next,
        ], $code);
    }
}
