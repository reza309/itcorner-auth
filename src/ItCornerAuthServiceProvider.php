<?php

namespace ItCorner\Auth;

use Illuminate\Support\ServiceProvider;

class ItCornerAuthServiceProvider extends ServiceProvider
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
        //
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views/auth/', 'auth');
        $this->publishes([
            __DIR__.'/views/auth' => resource_path('views/auth'),
        ]);
    }
}
