<?php

namespace App\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function loginUser(array $credentials);

    public function getUserRecord(int $userId):?User;

    public function logOutUser($user);
}