<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userRepository->register($request->only('name', 'email', 'password'));
        $token = $this->userRepository->login($request->only('email', 'password'));

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $credentials = $request->only('email', 'password');
        $token = $this->userRepository->login($credentials);

        if (is_string($token)) {
            return response()->json(compact('token'));
        }

        return $token;
    }

    public function logout(Request $request)
    {
        try {
            $token = $request->header('Authorization');

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

    public function getUser()
    {
        $user = $this->userRepository->getUser();

        if (is_object($user)) {
            return response()->json(compact('user'));
        }

        return $user;
    }
}
