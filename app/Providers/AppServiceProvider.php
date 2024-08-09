<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\Contracts\UserAuthenticationInterface;
use App\Repositories\Contracts\UserRegistrationInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserRegistrationInterface::class, UserRepository::class);
        $this->app->bind(UserAuthenticationInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
