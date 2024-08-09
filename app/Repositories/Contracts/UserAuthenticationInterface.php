<?php

namespace App\Repositories\Contracts;

interface UserAuthenticationInterface
{
    public function login(array $data): mixed;
    public function logout(string $token): bool;
    public function getAuthenticatedUser(): void;
}
