<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Pakai: role:user | role:penjual | role:admin
    // Atau multi: role:admin,penjual
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Jika role user tidak ada di daftar role yang diizinkan → tolak
        if (!in_array($user->role, $roles, true)) {
            // Bisa 403 atau redirect; pilih salah satu
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            // atau:
            // return redirect()->route('home')->withErrors('Akses ditolak.');
        }

        return $next($request);
    }
}
