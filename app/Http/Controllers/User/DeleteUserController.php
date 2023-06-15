<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\DeleteUserRequest;
use Illuminate\Http\JsonResponse;
use Request;

class DeleteUserController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        $deleteResult = $this->repository->delete();
        return response()->json(['success' => $deleteResult]);
    }
}
