<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class aff_status_approved
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
        if(Auth::check() && Auth::user()->aff_status_approved) {
            return $next($request);
        }
        return redirect()->route('home_redirect');
    }
}
