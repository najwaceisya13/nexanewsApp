<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk proteksi halaman admin
 * Hanya user dengan role admin yang bisa akses
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check apakah user adalah admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Tidak diizinkan mengakses halaman ini');
        }

        return $next($request);
    }
}
