<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;

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
        // Register middleware aliases for role-based routes
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('buyer', BuyerOnly::class);
        $router->aliasMiddleware('artist', ArtistOnly::class);
        $router->aliasMiddleware('admin', AdminOnly::class);

        // ===============================
        // AUTO CREATE SQLITE DATABASE FILE
        // ===============================
        $dbPath = database_path('database.sqlite'); // path ke database
        if (!File::exists($dbPath)) {
            File::put($dbPath, ''); // buat file kosong
        }
    }
}
