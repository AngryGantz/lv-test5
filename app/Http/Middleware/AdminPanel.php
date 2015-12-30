<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class AdminPanel
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
        if(Sentinel::inRole('admin')) return $next($request);
        return redirect('/');
    }
}
