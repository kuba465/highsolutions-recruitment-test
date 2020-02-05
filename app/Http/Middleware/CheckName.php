<?php

namespace App\Http\Middleware;

use Closure;

class CheckName
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
        if (!preg_match('/[A-Za-z0-9-_]+/', $request->name)) {
            return response(__('swapi.wrong_name'), 400);
        }

        return $next($request);
    }
}
