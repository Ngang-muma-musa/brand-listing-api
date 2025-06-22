<?php

namespace App\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function find(int $id): ?User;
    public function findByEmail(string $email): ?User;
}