<?php

namespace App\Http\Middleware;

use App\Helpers\Auth;
use Closure;

class IsAdmin
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
        return Auth::isAdmin() ? $next($request) : abort("404","sorry you have to be admin");
    }
}
