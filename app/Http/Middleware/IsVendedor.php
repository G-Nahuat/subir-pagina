<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsVendedor
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->tipo == 2) {
            return $next($request);
        }

        return redirect('/')->with('error', '🚨 ¡Este lugar es solo para vendedores, chavo! 🚨');
    }
}
