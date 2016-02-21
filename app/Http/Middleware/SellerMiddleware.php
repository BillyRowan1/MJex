<?php

namespace Mjex\Http\Middleware;

use Closure;

class SellerMiddleware
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
        if($request->user()->type != 'seller') {
            return redirect('/')->with('message','Please log in or sign up as Seller to access');
        }
        return $next($request);
    }
}
