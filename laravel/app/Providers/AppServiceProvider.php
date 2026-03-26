<?php

namespace App\Providers;

use App\Contracts\Suite\SuiteRepositoryInterface;
use App\Contracts\Suite\SuiteServiceInterface;
use App\Contracts\UserRepositoryInterface;
use App\Contracts\UserServiceInterface;
use App\Repositories\SuiteRepository;
use App\Repositories\UserRepository;
use App\Service\UserService;
use App\Service\SuiteService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(SuiteRepositoryInterface::class, SuiteRepository::class);
        $this->app->bind(SuiteServiceInterface::class, SuiteService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
