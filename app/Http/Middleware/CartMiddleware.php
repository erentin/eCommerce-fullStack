<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Cart\Contracts\CartInterface;

class CartMiddleware
{
    public function __construct(protected CartInterface $cart)
    {
        
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if(!$this->cart->exists())
        {
            $this->cart->create($request->user());
        }
        return $next($request);
    }
}
