<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function login($data) : User;
    public function register($data) : User;
    public function logout();
    public function delete();
    public function updatePhoto(User $user, $file) : User;

    public function setWishes($wishes);

    public function isUserSelectedWishes(): bool;

    public function editUser($data) : User;
}
