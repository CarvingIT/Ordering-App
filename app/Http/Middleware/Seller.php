<?php

namespace App\Http\Middleware;

use Closure;

class Seller
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
        if(!$request->user() || (!$request->user()->hasRole('admin') && !$request->user()->hasRole('seller'))){

            // Needs more work. Redirect user to a page that shows permission-denied message
            return redirect('/home');
        }
        return $next($request);
    }
}

