<?php

namespace App\Http\Middleware;

use App\Http\Models\Person;
use Closure;

class NotEmptySwapiTable
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
        if (!Person::all()->count()) {
            return response(__('swapi.empty_table'), 200);
        }

        return $next($request);
    }
}