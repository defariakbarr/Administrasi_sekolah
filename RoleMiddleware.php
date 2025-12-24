<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah pengguna sudah login di guard yang diminta (admin/guru/siswa)
        if (!Auth::guard($role)->check()) {
            // Kalau belum login, tendang balik ke halaman login
            return redirect('/login');
        }

        return $next($request);
    }
}