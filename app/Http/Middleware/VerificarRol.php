<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    /**
     * Verifica que el usuario tenga el rol requerido
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Verificar si el usuario autenticado tiene alguno de los roles permitidos
        if (!in_array(auth()->user()->rol, $roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'No tenés permisos para acceder a esa sección.');
        }

        return $next($request);
    }
}