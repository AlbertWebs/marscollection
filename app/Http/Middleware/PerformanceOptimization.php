<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PerformanceOptimization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only apply performance headers to HTML responses and NOT for admin pages
        if ($response instanceof Response && $this->isHtmlResponse($response)) {
            if ($request->is('admin') || $request->is('admin/*')) {
                // For admin pages, ensure no caching at all
                $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
                $response->headers->set('Pragma', 'no-cache');
                $response->headers->set('Expires', '0');
            } else {
                $this->addPerformanceHeaders($response);
            }
        }

        return $response;
    }

    /**
     * Check if the response is HTML
     */
    private function isHtmlResponse(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type');
        return $contentType && str_contains($contentType, 'text/html');
    }

    /**
     * Add performance optimization headers
     */
    private function addPerformanceHeaders(Response $response): void
    {
        // Cache control for static assets
        $response->headers->set('Cache-Control', 'public, max-age=3600, s-maxage=86400');
        
        // Enable compression
        $response->headers->set('Vary', 'Accept-Encoding');
        
        // Security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Referrer policy for SEO
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Permissions policy
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        // Content Security Policy for better security and performance
        $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.bunny.net http://localhost:5173 http://localhost:5174 http://localhost:5175 http://127.0.0.1:5173 http://127.0.0.1:5174 http://127.0.0.1:5175; style-src 'self' 'unsafe-inline' https://fonts.bunny.net http://localhost:5173 http://localhost:5174 http://localhost:5175 http://127.0.0.1:5173 http://127.0.0.1:5174 http://127.0.0.1:5175; font-src 'self' https://fonts.bunny.net; img-src 'self' data: https:; connect-src 'self' http://localhost:5173 http://localhost:5174 http://localhost:5175 http://127.0.0.1:5173 http://127.0.0.1:5174 http://127.0.0.1:5175; frame-src https://www.youtube.com https://youtube.com; object-src 'none';";
        $response->headers->set('Content-Security-Policy', $csp);
    }
}
