<?php

namespace ItCorner\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Kernel;
use ItCorner\Auth\Middleware\ItCornerAuthLoggedIn;
use ItCorner\Auth\Middleware\ItCornerAthenticate;
use Illuminate\Routing\Router;
use ItCorner\Auth\Console\ItcornerAuthCommand;

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
            __DIR__.'/routes'=>"routes",
            __DIR__.'/public' => public_path(),
            __DIR__.'/migrations' => database_path('migrations/'),
            __DIR__.'/Models' => database_path('Models/'),
            // __DIR__.'/Http/kernel.php' => app_path('Http/kernel.php'),
        ],'it-corner-auth-publish');


        $kernel->pushMiddleware(ItCornerAthenticate::class);
        $kernel->pushMiddleware(ItCornerAuthLoggedIn::class);
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('isLoggedIn', ItCornerAuthLoggedIn::class);
        $router->aliasMiddleware('isAuthenticate', ItCornerAthenticate::class);
        $this->loadViewsFrom(__DIR__.'/views/auth/', 'auth');


        // Register the command if we are using the application via the CLI
        if($this->app->runningInConsole())
        {
            $this->commands([
                ItCornerAuthCommand::class,
            ]);
        }
    }
}
