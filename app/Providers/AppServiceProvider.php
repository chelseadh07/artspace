<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

use App\Http\Middleware\BuyerOnly;
use App\Http\Middleware\ArtistOnly;
use App\Http\Middleware\AdminOnly;

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
        // Auto-run migration in production
        if (config('app.env') === 'production') {
            try {
                // Check if migrations table exists, if not run migrations
                if (! \Illuminate\Support\Facades\Schema::hasTable('migrations')) {
                    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
                }
            } catch (\Exception $e) {
                // Silent fail - don't break app if migration fails
            }
        }

        // Register middleware aliases for role-based routes
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('buyer', BuyerOnly::class);
        $router->aliasMiddleware('artist', ArtistOnly::class);
        $router->aliasMiddleware('admin', AdminOnly::class);
    }
}
