<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        // Admin → allow everything
        if ($user->role == 1) {
            return $next($request);
        }

        $routeName = $request->route()->getName();

        if ($routeName && $user->can($routeName)) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access this page.');
    }


    
}
