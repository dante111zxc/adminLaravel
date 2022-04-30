<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class ckFinderAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        config(['ckfinder.authentication' => function() use ($request) {
            return true;
        }] );

        return $next($request);
    }
}
