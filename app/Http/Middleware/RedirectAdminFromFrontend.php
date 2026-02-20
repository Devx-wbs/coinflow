<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectAdminFromFrontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // If NOT logged in → allow
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Only redirect if user is logged in AND is admin
        if (
            $request->getHost() === 'coinflowspay.com' &&
            $user->hasRole(['admin', 'sub_admin', 'support'])
        ) {
            return redirect()->away('https://admincp.coinflowspay.com/dashboard');
        }

        return $next($request);
    }
}
