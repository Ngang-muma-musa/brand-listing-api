<?php

namespace App\Repositories\Eloquent;

use App\Contracts\UserRepositoryInterface;
use App\Models\User; // Ensure you import your User model
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash; // For password hashing

class UserRepository implements UserRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
    
    public function find(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}