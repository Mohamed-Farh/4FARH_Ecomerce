<?php

namespace App\Http\Middleware;

use Closure;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckCart
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
        if (auth()->check() && Cart::instance('default')->count() > 0) {
            return $next($request);
        }

        toast('Sorry, Your Cart Is Empty!', 'error');
        return redirect()->route('frontend.index');
    }
}
