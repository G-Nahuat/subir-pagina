<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->tipo == 1) {
            return $next($request);
        }

        // Aquí forzamos cierre de sesión
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('error', '🚨 ¡A dónde vas chavo! No tienes permiso de entrar aquí, tu intento de acceso será notificado a la administración. 🚨');
    }
}
