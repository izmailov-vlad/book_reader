<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\RegisterPostRequest;
use App\Http\Resources\User\RegisterResource;
use App\Models\User;

class RegistrationController extends BaseController
{
    public function __invoke(RegisterPostRequest $request): RegisterResource
    {
        $data = $request->validated();
        $user = $this->repository->register($data);
        $token = $user->createToken(request('email'))->plainTextToken;
        return new RegisterResource(User::find($user->id));
    }
}
