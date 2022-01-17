<?php

namespace Itcorner\Auth\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Session;
use Closure;
class ItCornerAuthLoggedIn
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
        if((Session::has('loginId') || Cookie::has('remember_me')) && ((url('login')==$request->url()) || (url('register')==$request->url())))
        {
            return redirect()->back();
        }
        return $next($request);
    }
}
