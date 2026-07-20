<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Agrega cabeceras de seguridad HTTP a todas las respuestas
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // PS-01 — Content Security Policy
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; font-src 'self' https://cdn.jsdelivr.net; img-src 'self' data:;"
        );

        // PS-03 — Anti-Clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // PS-05 — Ocultar X-Powered-By
        $response->headers->remove('X-Powered-By');

        // PS-06 — X-Content-Type-Options
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Extra — X-XSS-Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Extra — Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}