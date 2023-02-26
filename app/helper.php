<?php

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

function sendResponse(
    int $httpCode = Response::HTTP_OK,
    array $data = null,
    array $error = null,
    $message = null,
    $statusCode = "SUCCESS",
) {
    return response()->json([
        'timestamp' => Carbon::now(),
        'status' => $statusCode,
        'message' => $message,
        'error' => $error,
        'data' => $data,
    ], $httpCode
);
}
