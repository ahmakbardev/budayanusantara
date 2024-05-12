<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Periksa role_id pengguna
                if ($user->role_id == 1) {
                    // Jika role_id adalah 1 (admin), redirect ke prefix admin
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                } elseif ($user->role_id == 2) {
                    // Jika role_id adalah 2 (user), redirect ke prefix user
                    return redirect(RouteServiceProvider::USER_HOME);
                }
            }
        }

        return $next($request);
    }
}
