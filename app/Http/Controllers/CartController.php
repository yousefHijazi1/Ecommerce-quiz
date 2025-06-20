<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('cart', compact('cartItems'));
    }
    public function add(Request $request)
{
    if (!Auth::check()) {
        session()->put('product_id', $request->product_id);
        session()->put('quantity', $request->quantity ?? 1); // default to 1 if not specified
        return redirect()->route('login')->with('error', 'Please login to add product to cart');
    }

    // Get product_id and quantity either from request or session
    $product_id = $request->product_id ?? session()->get('product_id');
    $quantity = $request->quantity ?? session()->get('quantity', 1); // default to 1

    // Validate the input
    if (!$product_id) {
        return back()->with('error', 'Product not specified');
    }

    // Clear session variables if they existed
    if (session()->has('product_id')) {
        session()->forget('product_id');
        session()->forget('quantity');
    }

    // Update or create cart item
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

    return back()->with('success', 'Product added to cart');
}

    public function addAfterLogin(Request $request)
    {
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

            return back()->with('success', 'Product added to cart');
        }
    }

    public function updateCart(Request $request)
    {
        $cartItem = Cart::find($request->id);
        $product = Product::find($cartItem->product_id);

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($newQuantity > $product->quantity) {
                return response()->json(['error' => 'Insufficient quantity available. Only ' . $product->quantity . ' items are available.']);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            dd($cartItem->quantity);
            return response()->json(['quantity' => $cartItem->quantity]);
        }
    }

    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();
        
        return back()->with('success', 'Item removed from cart');
    }

}
