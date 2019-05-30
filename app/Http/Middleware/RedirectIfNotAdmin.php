<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    const LOGIN_PATH = '/admin/login';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = ADMIN_GUARD)
    {
        if (Auth::guard($guard)->check()) {
            return $next($request);
        }

        return redirect(self::LOGIN_PATH);
    }
}
