<?php

namespace Tests\Unit;

use App\Http\Controllers\User\RegistrationController;
use App\Http\Requests\User\RegisterPostRequest;
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
        $token = $registerResponse->decodeResponseJson()['data']['token'];

        $deleteUserBody = ['email' => 'test_gmail@gmail.com'];
        $deleteUserResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/user/delete', $deleteUserBody);

        $deleteUserResponse->assertOk();
    }
}
