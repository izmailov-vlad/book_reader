<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdatePhotoRequest;
use App\Models\User;
use Auth;

class UpdatePhotoController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePhotoRequest $request)
    {
        $request->validated();
        $user = User::find(Auth::user()->id);

        if (!$user) {
            abort(404);
        }

        if ($request->hasFile('photo')) {
            return $this->repository->updatePhoto($user, $request->file('photo'));
        }
    }
}
