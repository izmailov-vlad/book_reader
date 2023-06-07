<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_login()
    {
        $userJson = [
            'name' => 'test_name',
            'email' => 'test_gmail@gmail.com',
            'password' => 'test_password'
        ];
        $user = User::where('email', 'test_gmail@gmail.com')->first();

        if (!is_null($user)) {
            $user->delete();
        }
        $registerResponse = $this->post('api/user/register', $userJson);
        $registerResponse->assertOk();

        $loginResponse = $this->post('api/user/login', [
                'email' => 'test_gmail@gmail.com',
                'password' => 'test_password'
            ],
        );
        $loginResponse->assertOk();
    }
}
