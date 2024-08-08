<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function register(array $data);

    public function login(array $data);

    public function logout(string $token): bool;

    public function getAuthenticatedUser();
}
