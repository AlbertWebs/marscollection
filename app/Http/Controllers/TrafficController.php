<?php

namespace App\Http\Controllers;

use App\Models\TrafficVisit;
use Illuminate\Http\Request;

class TrafficController extends Controller
{
    public function heartbeat(Request $request)
    {
        if ($request->user()?->is_admin) {
            return response()->json(['ok' => true]);
        }

        $sessionId = $request->session()->getId();
        $visitorKey = hash_hmac('sha256', $sessionId, (string) config('app.key'));
        $path = '/' . ltrim(mb_substr((string) $request->input('path', '/'), 0, 191), '/');
        if (str_starts_with($path, '/admin')) {
            $path = '/';
        }

        $visit = TrafficVisit::where('visitor_key', $visitorKey)->latest('visited_at')->first();
        if ($visit) {
            $visit->update(['path' => $path, 'visited_at' => now()]);
        } else {
            TrafficVisit::create(['visitor_key' => $visitorKey, 'path' => $path, 'visited_at' => now()]);
        }

        return response()->json(['ok' => true]);
    }
}
