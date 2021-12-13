<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Interfaces\SwaggerInterface;
use App\Repository\SwaggerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(SwaggerInterface::class, SwaggerRepository::class);
        $this->app->bind(SwaggerAdminInterface::class, SwaggerAdminRepository::class);
    }
}
