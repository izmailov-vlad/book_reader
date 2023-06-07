<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_register(): void
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

        $response = $this->post('api/user/register', $userJson);
        $response->assertOk();
    }
}
