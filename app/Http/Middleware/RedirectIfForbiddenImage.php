<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfForbiddenImage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $imagePath = public_path('storage/images/signature/' . $request->segment(2));

        if (!File::exists($imagePath) || !is_readable($imagePath)) {
            return redirect()->to('blank.png');
        }

        return $next($request);
    }
}
