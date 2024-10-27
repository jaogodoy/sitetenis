<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    protected $routeMiddleware = [
        // outros middlewares...
        'client.auth' => \App\Http\Middleware\ClientAuth::class,
        'admin.auth' => \App\Http\Middleware\AdminAuth::class, // Se você tiver esse middleware
        'auth' => \App\Http\Middleware\Authenticate::class,
    ];

}
