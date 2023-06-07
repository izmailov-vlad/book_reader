<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User\LoginResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class LoginController extends BaseController
{
    public function __invoke(LoginRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->repository->login($data);
            return new LoginResource(User::find($user->id));
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['error'=>$exception->getMessage()]);
        }
    }
}
