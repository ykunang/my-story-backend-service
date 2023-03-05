<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationRegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */

     public function test_register_should_failure_when_no_password_confirmation(): void
     {
         // act
         $payload = ['name' => 'joko', 'email' => 'joko@gmail.com', 'password' => '12345678'];
         $response = $this->post('/api/auth/register', $payload, $this->header);

         // expect
         $response->assertStatus(422);
         $this->assertSame($response->json('error.password_confirmation')[0],'The password confirmation field is required.');
     }

     public function test_register_should_failure_when_email_already_exist(): void {

        // stubs
        $exsitUser = [
            'name' => 'jaka sembung',
            'email' => 'joko@gmail.com',
            'password' => Hash::make('12345678'),
        ];

        User::create($exsitUser);

        // act
        $payload = ['name' => 'joko', 'email' => 'joko@gmail.com', 'password' => '12345678', 'password_confirmation' => '12345678'];
        $response = $this->post('/api/auth/register', $payload, $this->header);

        // expect
         $response->assertStatus(422);
         $this->assertSame($response->json('error.email')[0],'The email has already been taken.');
     }


     public function test_register_should_success(): void {

        // act
        $payload = ['name' => 'joko', 'email' => 'joko@gmail.com', 'password' => '12345678', 'password_confirmation' => '12345678'];
        $response = $this->post('/api/auth/register', $payload, $this->header);

        // expect
        $responseJson = $response->json('data');

        $response->assertStatus(200);
        $this->assertSame($responseJson['name'], 'joko');
        $this->assertSame($responseJson['email'], 'joko@gmail.com');
     }
}
