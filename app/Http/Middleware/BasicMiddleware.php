<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('Authorization');

        if (!$header || !str_starts_with($header, 'Basic ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $encoded = substr($header, 6);
        $decoded = base64_decode($encoded);

        [$username, $password] = explode(':', $decoded);

        if ($username !== 'kedokteranuinsa' || $password !== 'FKuins4') {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $next($request);
    }
}
