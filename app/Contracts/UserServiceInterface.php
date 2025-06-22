<?php

namespace App\Contracts;

interface UserServiceInterface
{
    public function login(array $credentials);

    public function logout($user);
}