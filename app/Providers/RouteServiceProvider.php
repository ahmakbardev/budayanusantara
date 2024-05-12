<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const ADMIN_HOME = '/admin/dashboard'; // Tentukan route untuk admin
    public const USER_HOME = '/user'; // Tentukan route untuk user

    // Setelah pengguna berhasil login
    protected function authenticated(Request $request, $user)
    {
        // Periksa role_id pengguna
        if ($user->role_id == 1) {
            // Jika role_id adalah 1 (admin), redirect ke prefix admin
            return redirect(self::ADMIN_HOME);
        } elseif ($user->role_id == 2) {
            // Jika role_id adalah 2 (user), redirect ke prefix user
            return redirect(self::USER_HOME);
        }
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
