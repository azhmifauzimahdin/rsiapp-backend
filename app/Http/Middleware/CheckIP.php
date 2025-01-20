<?php

namespace App\Http\Middleware;

use App\Models\IpAddress;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type = 0): Response
    {
        $ipAddress = $request->ip();

        if (IpAddress::where('name', $ipAddress)->where('type', $type)->first()) {
            return $next($request);
        }

        $response = [
            'success' => false,
            'code' => 401,
            'message' => 'Unauthorised'
        ];
        return response()->json($response, 401);
    }
}
