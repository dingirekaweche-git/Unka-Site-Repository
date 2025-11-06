<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // You can add API rate limiting here if needed
    }

    /**
     * Optional: Get redirect path based on user role.
     */
    public static function redirectToBasedOnRole()
    {
        $user = Auth::user();

        if (!$user) {
            return '/login';
        }

        if ($user->role === 'system_admin') {
            return '/dashboard';
        } elseif ($user->role === 'association_admin') {
            return '/dashboard';
        } else {
            return '/dashboard';
        }
    }
}
