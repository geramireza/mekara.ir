<?php

namespace App\Http\Middleware;

use App\Helpers\Auth;
use Closure;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return Auth::isLogin() ? $next($request) : redirect()->route("login");
    }
}
