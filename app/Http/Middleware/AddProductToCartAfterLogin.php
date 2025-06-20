<?php
// app/Http/Middleware/AddProductToCartAfterLogin.php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddProductToCartAfterLogin
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route() !== null && $request->route()->getName() === 'login') {
            if (session()->has('product_id')) {
                $product_id = session()->get('product_id');
                $quantity = session()->get('quantity');
                session()->forget('product_id');
                session()->forget('quantity');

                $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $product_id)
                    ->first();

                if ($cart) {
                    $cart->quantity += $quantity;
                    $cart->save();
                } else {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                    ]);
                }
            }
        }

        return $next($request);
    }
}
