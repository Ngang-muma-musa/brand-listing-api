<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;
use Laravel\Passport\Client;

class UserController extends Controller
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only(['email', 'password']);
            
            $token = $this->userService->login($credentials);

            return response()->json([
                'token_type' => 'Bearer',
                'access_token' => $token,
                'message' => 'Login successful'
            ], 200);

        } catch (Throwable $e) {

            Log::error('Error logging in user: ' . $e->getMessage(), [
                'trace' => $e->getTrace(),
                'credentials' => $credentials
            ]);

            return response()->json(['message' => 'Failed to log in: '. $e->getMessage()], 401);
        }        
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

}