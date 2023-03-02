<?php

namespace Tests\Unit;

use App\Http\Services\AuthService;
use App\Http\Services\AuthServiceImpl;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthServiceTest extends TestCase
{

    private AuthService $authService;
    private array $credential;

    public function setUp():void
    {
        parent::setUp();
        $this->authService = new AuthServiceImpl();
        $this->credential = ['email' => 'joko@gmail.com', 'password' => 'joko12345678'];
    }

    public function test_should_throw_bad_request_exception(): void
    {
        // stubs
        Auth::shouldReceive('attempt')->once()->andReturn(false);

        $this->expectException(BadRequestHttpException::class);
        $this->authService->login($this->credential);
    }

    public function test_should_success_and_return_token(): void
    {
        // stubs
        $userData = [
            'name' => 'joko','email' => 'joko@gmail.com','password' => Hash::make('12345678'),
        ];

        $userModel = User::create($userData);

        Auth::shouldReceive('attempt')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($userModel);
        // // act
        $result = $this->authService->login($this->credential);
        // assert
        $this->assertNotNull($result);
    }


    public function test_get_profile(): void
    {
        // stub
        $userData = [
            'name' => 'joko','email' => 'joko@gmail.com','password' => Hash::make('12345678'),
        ];

        $userModel = User::create($userData);
        Auth::shouldReceive('user')->once()->andReturn($userModel);
        // act
        $userProfile = $this->authService->profile();
        // assert
        $this->assertSame($userModel, $userProfile);
    }


    public function test_register_user_should_success(): void
    {
        // stub
        $userData = [
            'name' => 'joko','email' => 'joko@gmail.com','password' => '12345678',
        ];

        // act
        $result = $this->authService->register($userData);

        // assert
        $this->assertSame($result['name'], $userData['name']);
        $this->assertSame($result['email'], $userData['email']);
    }
}
