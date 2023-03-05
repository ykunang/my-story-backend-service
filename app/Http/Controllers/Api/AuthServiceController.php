<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\AuthService;


class AuthServiceController extends Controller
{
    public function __construct(private AuthService $auth)
    {}

    public function login(LoginRequest $request)
    {
        $result = $this->auth->login($request->safe()->all());
        return $this->responseSuccess(data:['token' => $result], message: 'Login successfull');
    }


    public function register(RegisterRequest $request)
    {
        $user = $this->auth->register($request->safe()->all());
        return $this->responseSuccess(message: 'Register successfull', data: $user);
    }

    public function getProfile()
    {
        $result = $this->auth->profile();
        return $this->responseSuccess(data: $result->toArray());
    }
}
