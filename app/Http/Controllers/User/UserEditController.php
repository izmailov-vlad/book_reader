<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserEditRequest;
use App\Http\Resources\User\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserEditController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserEditRequest $request)
    {
        $data = $request->validated();
        $user = $this->repository->editUser($data, $request->file('photo'));
        return response()->json($user);
    }
}
