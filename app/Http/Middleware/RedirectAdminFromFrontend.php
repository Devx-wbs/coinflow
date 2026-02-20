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
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            if (
                $request->getHost() === 'coinflowspay.com' &&
                $user->hasRole(['admin', 'sub_admin', 'support'])
            ) {
                return redirect()->away('https://admincp.coinflowspay.com/dashboard');
            }
        }

        return $next($request);
    }
}
