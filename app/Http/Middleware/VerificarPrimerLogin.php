<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarPrimerLogin
{
    /**
     * Si el usuario no ha cambiado su contraseña temporal,
     * lo redirige obligatoriamente a la pantalla de cambio.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->primer_login) {
            // Permitir solo las rutas de cambio de contraseña y logout
            if (!$request->routeIs('auth.cambiar-password') &&
                !$request->routeIs('auth.cambiar-password.post') &&
                !$request->routeIs('auth.logout')) {
                return redirect()->route('auth.cambiar-password');
            }
        }

        return $next($request);
    }
}