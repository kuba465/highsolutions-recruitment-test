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
        $name = $request->name;

        if (is_null($name)) {
            return response(__('swapi.no_name'), 404);
        }

        if (!preg_match('/[A-Za-z0-9-_]+/', $name)) {
            return response(__('swapi.wrong_name'), 404);
        }

        return $next($request);
    }
}
