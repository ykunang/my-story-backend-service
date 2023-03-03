<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\AuthService;


class AuthServiceController extends Controller
{
    function __construct(private AuthService $auth) {}

    function login(LoginRequest $request) {
        $result = $this->auth->login($request->safe()->all());
        return $this->responseSuccess(
            data:['token' => $result],
            message: 'Login successfull'
        );
    }


    function register(RegisterRequest $request) {
        $user = $this->auth->register($request->safe()->all());
        return $this->responseSuccess(message: 'Register successfull', data: $user);
    }

    function getProfile() {
        $result = $this->auth->profile();
        return $this->responseSuccess(data: $result->toArray());
    }
}
