<?php

namespace ItCorner\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Kernel;
use ItCorner\Auth\Middleware\ItCornerAuthLoggedIn;
use ItCorner\Auth\Middleware\ItCornerAthenticate;
use Illuminate\Routing\Router;

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
    public function boot(Kernel $kernel)
    {
        //
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        
        $this->publishes([
            __DIR__.'/views' => resource_path('views/'),
        ],'It-Corner-authe-view');
        $this->publishes([
            __DIR__.'/public' => public_path(),
            // __DIR__.'Middleware'=>middleware_path(),
        ],'IT-Corner-authe-asset');
        $kernel->pushMiddleware(ItCornerAthenticate::class);
        $kernel->pushMiddleware(ItCornerAuthLoggedIn::class);
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('isLoggedIn', ItCornerAuthLoggedIn::class);
        $router->aliasMiddleware('isAuthenticate', ItCornerAthenticate::class);
        $this->loadViewsFrom(__DIR__.'/views/auth/', 'auth');
    }
}
