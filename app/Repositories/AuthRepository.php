<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserAuthenticationInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthRepository implements UserAuthenticationInterface
{
    public function login(array $credentials): mixed
    {
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return $token;
    }

    public function logout(string $token): bool
    {
        try {
            JWTAuth::setToken($token)->invalidate();
            return true;
        } catch (JWTException $e) {
            return false;
        }
    }

    public function getAuthenticatedUser(): void
    {
    }
}
