<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckAccountLoginMiddle
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
        if(Session::has('user') == true) {
            if($request->path() == 'user/login')
                return redirect('/user/isLogin');
            return $next($request);
        } else if($request->path() == 'user/login') {
            return $next($request);
        }

        return redirect('/user/isLogin');
    }
}
