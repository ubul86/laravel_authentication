<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRegistrationInterface
{
    public function register(array $data): User;
}
