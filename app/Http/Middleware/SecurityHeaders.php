<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Prevent clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Enable XSS filtering (legacy browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Control referrer information
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Disable browser features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        // Content Security Policy (CSP)
        // Adjust based on your needs (CKEditor, Alpine.js, etc)
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdn.ckeditor.com https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com",
            "img-src 'self' data: https: blob:",
            "font-src 'self' data: https://fonts.gstatic.com",
            "connect-src 'self'",
            "media-src 'self' https://www.youtube.com https://www.youtube-nocookie.com",
            "frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com https://www.google.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ];
        
        $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        
        // Strict Transport Security (HTTPS only - uncomment when using SSL)
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        
        return $response;
    }
}
