<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface extends UserRegistrationInterface, UserAuthenticationInterface
{
    public function getUser(): mixed;
}
