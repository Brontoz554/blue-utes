<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() != null) {
            if (Auth::user()->role->name == 'admin') {
                return $next($request);
            }
        } else {
            return redirect(RouteServiceProvider::PROFILE);
        }

        return $next($request);
    }
}
