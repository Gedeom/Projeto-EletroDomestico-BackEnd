<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    UserRepositoryInterface,
    MarcaRepositoryInterface,
    EletrodomesticoRepositoryInterface
};
use App\Repositories\{
    UserRepository,
    MarcaRepository,
    EletrodomesticoRepository
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            MarcaRepositoryInterface::class,
            MarcaRepository::class
        );

        $this->app->bind(
            EletrodomesticoRepositoryInterface::class,
            EletrodomesticoRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
