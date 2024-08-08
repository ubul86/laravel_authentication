<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $this->userRepository->register($request->only('name', 'email', 'password'));
        $token = $this->userRepository->login($request->only('email', 'password'));

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $credentials = $request->only('email', 'password');
        $token = $this->userRepository->login($credentials);

        if (is_string($token)) {
            return response()->json(compact('token'));
        }

        return $token;
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $token = $request->header('Authorization', '');

            if (strpos($token, 'Bearer ') === 0) {
                $token = substr($token, 7);
            }

            if ($this->userRepository->logout($token)) {
                return response()->json(['message' => 'Successfully logged out'], 200);
            }

            return response()->json(['error' => 'Could not invalidate token'], 500);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not invalidate token'], 500);
        }
    }

    public function getUser(): JsonResponse
    {
        $user = $this->userRepository->getUser();

        return response()->json(compact('user'));
    }
}
