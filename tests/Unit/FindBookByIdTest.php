<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class FindBookByIdTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
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
        $token = $loginResponse->decodeResponseJson()['data']['token'];;
        $bookHeader = ['Authorization' => 'Bearer ' . $token];

        $bookResponse = $this->get('api/book/book-by-id?book_id=u5a8DwAAQBAJ', $bookHeader);

        // Assert
        $bookResponse->assertOk();
    }
}
