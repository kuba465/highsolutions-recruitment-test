<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class VerifyToken
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
        $token = $request->token;

        if ($token !== config('app.api_token')) {
            return response(__('swapi.wrong_token'), 404);
        }

        return $next($request);
    }
}
