<?php

namespace App\Repository;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\User\UserWishes;
use Auth;
use File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use InvalidArgumentException;
use Storage;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @throws ValidationException
     */
    public function login($data): User
    {
        $user = User::where('email', $data['email'])->first();

        if (is_null($user)) {
            throw ValidationException::withMessages([
                'status' => ['User  not found'],
            ]);
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new InvalidArgumentException('The given password does not match the current password.');
        }
        return $user;
    }

    public function register($data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function logout(): bool
    {
        $user = request()->user();
        $user->tokens()->delete();
        return true;
    }

    public function delete(): bool
    {
        $userId = Auth::user()->id;
        User::find($userId)->delete();
        return true;
    }

    public function updatePhoto(User $user, $file): User
    {
        Storage::deleteDirectory('public/photos/' . $user->name);
        $path = Storage::putFile('public/photos/' . $user->name, $file);
        $user->update([
            'photo' => env('APP_URL', 'http://localhost') . Storage::url($path),
        ]);
        $user->save();
        return $user;
    }

    public function editUser($data): User
    {
        $user = Auth::user();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        $user->save();
        return $user;
    }

    public function setWishes($wishes)
    {
        $user = Auth::user();
        foreach ($wishes as $wish) {
            $userWishesModel = new UserWishes();
            $userWishesModel->user_id = $user->id;
            $userWishesModel->category_id = $wish['categoryId'];
            $userWishesModel->save();
        }
    }

    public function isUserSelectedWishes(): bool
    {
        $userWishes = UserWishes::where('user_id', Auth::user()->id)->get();
        return !$userWishes->isEmpty();
    }
}
