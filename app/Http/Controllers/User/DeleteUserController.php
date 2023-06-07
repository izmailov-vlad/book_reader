<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\DeleteUserRequest;
use Illuminate\Http\JsonResponse;

class DeleteUserController extends BaseController
{
    public function __invoke(DeleteUserRequest $request): JsonResponse
    {
        $request->validated();
        $deleteResult = $this->repository->delete();
        return response()->json(['success' => $deleteResult]);
    }
}
