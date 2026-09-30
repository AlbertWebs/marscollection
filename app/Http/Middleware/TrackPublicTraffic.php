<?php

namespace App\Http\Middleware;

use App\Models\TrafficVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPublicTraffic
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$request->isMethod('GET') || $response->getStatusCode() >= 400) {
            return $response;
        }

        $routeName = (string) optional($request->route())->getName();
        if (
            str_starts_with($routeName, 'admin.')
            || in_array($routeName, ['login', 'register', 'password.request', 'password.email', 'password.reset', 'password.update'], true)
            || $request->user()?->is_admin
            || $request->is('admin', 'admin/*', 'up', 'build/*', 'storage/*')
        ) {
            return $response;
        }

        $sessionId = $request->hasSession() ? $request->session()->getId() : null;
        if (!$sessionId) {
            return $response;
        }

        TrafficVisit::create([
            'visitor_key' => hash_hmac('sha256', $sessionId, (string) config('app.key')),
            'path' => '/' . ltrim(mb_substr($request->path(), 0, 191), '/'),
            'visited_at' => now(),
        ]);

        return $response;
    }
}
