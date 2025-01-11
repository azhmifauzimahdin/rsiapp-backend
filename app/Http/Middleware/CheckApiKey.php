<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('API-Key');

        if ($apiKey !== env('API_KEY')) {
            $response = [
                'success' => false,
                'code' => 401,
                'message' => 'Unauthorised'
            ];

            return response()->json($response, 401);
        }
        return $next($request);
    }
}
