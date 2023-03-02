<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_should_return_bad_request(): void
    {
        // act
        $payload = ['email' => 'test@gmail.com', 'password' => '12345678'];
        $response = $this->post('/api/auth/login',$payload, $this->header);

        // stub
        $response->assertBadRequest();
        $this->assertSame($response->json('message'), "email or password not found!");
    }

    public function test_login_should_success_and_return_token(): void
    {
        // stubs
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
        ]);

        // act
        $payload = ['email' => 'admin@gmail.com', 'password' => 'admin1234'];
        $response = $this->post('/api/auth/login', $payload, $this->header);

        // expect
        $response->assertStatus(200);
        $this->assertNotNull($response->json('data.token'));
    }
}
