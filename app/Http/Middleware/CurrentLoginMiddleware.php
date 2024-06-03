<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CurrentLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check()) {
            return $next($request);
        } elseif (Auth::guard('suppliers')->check()) {
            return $next($request);
        }

        // Mengecek apakah permintaan datang dari guard supplier
        if ($request->is('supplier/*')) {
            return redirect()->route('supplier.login');
        }

        // Redirect ke login pengguna biasa jika bukan supplier
        return redirect()->route('login');
    }
}
