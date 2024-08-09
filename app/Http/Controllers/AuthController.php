<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Contracts\UserAuthenticationInterface;
use App\Repositories\Contracts\UserRegistrationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    protected UserRegistrationInterface $userRegistration;

    protected UserAuthenticationInterface $authRepository;

    public function __construct(UserRegistrationInterface $userRegistration, UserRepositoryInterface $userRepository, UserAuthenticationInterface $authRepository)
    {
        $this->userRegistration = $userRegistration;
        $this->userRepository = $userRepository;
        $this->authRepository = $authRepository;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $this->userRegistration->register($request->only('name', 'email', 'password'));
        $token = $this->authRepository->login($request->only('email', 'password'));

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $credentials = $request->only('email', 'password');
        $token = $this->authRepository->login($credentials);

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

            if ($this->authRepository->logout($token)) {
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
