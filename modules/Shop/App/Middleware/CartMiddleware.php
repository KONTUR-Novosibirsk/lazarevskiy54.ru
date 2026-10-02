<?php

namespace Modules\Shop\App\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $cart = $request->session()->get('cart');

        if (empty($cart)) {
            $request->session()->put('cart', ['totalCount' => 0, 'items' => []]);
        }

        return $next($request);
    }
}
