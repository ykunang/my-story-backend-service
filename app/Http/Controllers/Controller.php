<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function responseSuccess(int $httpCode = Response::HTTP_OK, array $data = null, $message= null)
    {
        return sendResponse(data:$data, httpCode:$httpCode, message: $message);
    }

    protected function responseError(
        int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $error
    )
    {
        return sendResponse(error: $error, httpCode: $httpCode);
    }
}
