<?php

namespace ItCorner\Auth\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Session;
use Closure;
class ItCornerAthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Session()->has('loginId') && (Cookie::get('remember_me') == null))
        {
            return redirect('login')->with('fail','You hav to login first');
        }
        return $next($request);
    }
}
