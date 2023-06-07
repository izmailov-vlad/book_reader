<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_delete(): void
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
        $token = $registerResponse->json('token');

        var_dump(
            'token' . $token
        );

        $deleteUserHeader = ['Authorization' => 'Bearer ' . $token];
        $deleteUserBody = ['email' => 'test_gmail@gmail.com'];
        $deleteUserResponse = $this->post('api/user/delete', $deleteUserBody, $deleteUserHeader);

        $deleteUserResponse->assertOk();
    }
}
