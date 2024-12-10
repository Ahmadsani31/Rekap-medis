<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        try {
            $user = JWTAuth::parseToken()->authenticate();
            // dd($user);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed: Invalid token',
            ], 401);
        }

        return $next($request);
    }
}
