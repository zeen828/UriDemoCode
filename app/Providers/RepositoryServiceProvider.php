<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\UriSrtRepository::class, \App\Repositories\UriSrtRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UriLogRepository::class, \App\Repositories\UriLogRepositoryEloquent::class);
        //:end-bindings:
    }
}
