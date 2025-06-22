<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use App\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = $this->userRepository->findByEmail($credentials['email']);
            $user->tokens->each(function ($token) {
                $token->revoke();
            });
            return $user->createToken('Laravel Personal Access Client')->accessToken;
        }

        throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
    }

    public function logout($user)
    {
        foreach ($user->tokens as $token) {
            $token->revoke();
        }
        return true;
    }

    public function getUserById(int $userId)
    {
        return $this->userRepository->find($userId);
    }
}