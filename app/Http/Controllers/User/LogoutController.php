<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\LogoutRequest;
use Illuminate\Http\JsonResponse;

class LogoutController extends BaseController
{
    public function __invoke(LogoutRequest $request): JsonResponse
    {
        $request->validated();
        $logoutResult = $this->repository->logout();
        return response()->json(['success' => $logoutResult]);
    }
}
