<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function register(array $data): User;

    public function login(array $data): mixed;

    public function logout(string $token): bool;

    public function getAuthenticatedUser(): void;

    public function getUser(): mixed;
}
