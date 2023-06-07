<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $userId = $request->query('user_id');
        $token = User::find($userId)->createToken('token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
}
