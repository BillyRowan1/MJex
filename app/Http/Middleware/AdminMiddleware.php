<?php

namespace Mjex\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if($request->session()->has('mjexadmin')) {
            return $next($request);
        }
        return redirect()->to('mjexadmin/auth/login');
    }
}
