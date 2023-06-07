<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\BaseController;
use App\Http\Requests\User\UserWishesRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Request;

class UserWishesController extends BaseController
{
    public function setWishes(UserWishesRequest $request)
    {
        try {
            $wishes = $request->get('wishes');
            $this->repository->setWishes($wishes);
            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }

    public function isUserHaveWishes(Request $request)
    {
        try {
            $userHaveWishes = $this->repository->isUserSelectedWishes();
            return response()->json(['success' => $userHaveWishes]);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
