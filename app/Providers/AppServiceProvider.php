<?php

namespace App\Providers;

use App\Console\Commands\MakeRepository;
use App\Repositories\CitaRepository;
use App\Repositories\Contracts\CitaRepositoryInterface;
use App\Repositories\Contracts\CupoRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\SuscripcionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\CupoRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SuscripcionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->commands([
            MakeRepository::class,
        ]);

        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(CitaRepositoryInterface::class, CitaRepository::class);
        $this->app->bind(CupoRepositoryInterface::class, CupoRepository::class);
        $this->app->bind(SuscripcionRepositoryInterface::class, SuscripcionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
