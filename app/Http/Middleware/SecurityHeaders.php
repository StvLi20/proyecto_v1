<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Agrega cabeceras de seguridad HTTP a todas las respuestas.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // PS-01 — Content Security Policy (CSP)
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
            "font-src 'self' https://cdn.jsdelivr.net; " .
            "img-src 'self' data:; " .
            "connect-src 'self' https://cdn.jsdelivr.net; " .
            "frame-ancestors 'none'; " .
            "form-action 'self';"
        );

        // PS-03 — Protección contra Clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // PS-05 — Ocultar X-Powered-By
        $response->headers->remove('X-Powered-By');
        header_remove('X-Powered-By');

        // PS-06 — Evita MIME Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Protección XSS (compatibilidad con navegadores antiguos)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Controla la información Referer enviada a otros sitios
        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );

        return $response;
    }
}