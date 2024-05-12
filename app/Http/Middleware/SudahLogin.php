<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SudahLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Jika sudah login, lanjutkan permintaan
            return $next($request);
        }

        // Jika belum login, periksa prefix URL untuk menentukan redirect
        $urlPrefix = $request->route()->getPrefix();

        if ($urlPrefix == 'admin') {
            // Redirect ke halaman login untuk admin
            return redirect()->route('admin.index');
        } elseif ($urlPrefix == 'user') {
            // Redirect ke halaman login untuk user
            return redirect()->route('login.form');
        }

        // Jika prefix tidak ada, maka tampilkan halaman login default
        return redirect()->route('login.form');
    }
}
