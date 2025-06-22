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

    public function loginUser(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = $this->userRepository->findByEmail($credentials['email']);
            return $user->createToken('Laravel Personal Access Client')->accessToken;
        }

        throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
    }

    public function getUserRecord(int $userId):? User
    {
        return $this->userRepository->find($userId);
    }

    public function logOutUser($user)
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