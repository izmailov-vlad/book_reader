<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\GoogleAuth\LoginGoogleRequest;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function loginWithGoogle(LoginGoogleRequest $request)
    {
        $request->validated();
        $provider = "google";
        $token = $request->input('accessToken');
        $providerUser = Socialite::driver($provider)->userFromToken($token);
        $user = User::where('provider_name', $provider)
            ->where('provider_id', $providerUser->id)
            ->where('email', $providerUser->email)
            ->first();
        if ($user == null) {
            $user = User::create([
                'email' => $providerUser->email,
                'name' => $providerUser->name,
                'provider_name' => $provider,
                'provider_id' => $providerUser->id,
            ]);
        }
        $token = $user->createToken(env('APP_NAME'))->plainTextToken;
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }
}
