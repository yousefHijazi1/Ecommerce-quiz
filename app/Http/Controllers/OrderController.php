<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{

    public function index() {

        $orders = Auth::user()->orders()  // This will now work
            ->when(request('status'), function($query) {
                $query->where('status', request('status'));
            })
            ->when(request('search'), function($query) {
                $query->where(function($q) {
                    $q->where('id', 'like', '%'.request('search').'%')
                    ->orWhereHas('items.product', function($productQuery) {
                        $productQuery->where('name', 'like', '%'.request('search').'%');
                    });
                });
            })
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('orders', compact('orders'));
    }

    public function store(Request $request) {

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $cartItems = $user->cart()->with(['product' => function($query) {
                $query->where('quantity', '>=', 1);
            }])->get();

            $validCartItems = $cartItems->filter(fn($item) => $item->product);

            if ($validCartItems->isEmpty()) {
                return response()->json([
                    'error' => 'No valid products in cart'
                ], 400);
            }

            $subtotal = $validCartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $shipping = 10.00;
            $total = $subtotal + $shipping;

            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => 'Default address', // Update this with real data
                'billing_address' => 'Default address', // Update this with real data
            ]);

            foreach ($validCartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // Update product quantity
                $cartItem->product->decrement('quantity', $cartItem->quantity);
            }

            // Clear only the processed items from cart
            $user->cart()->whereIn('id', $validCartItems->pluck('id'))->delete();

            DB::commit();

            return response()->json([
                'redirect' => route('orders.show', $order)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Order $order) {
        $order->load('items.product');
        return view('orderDisplay', compact('order'));
    }

    public function cancel(Order $order, Request $request) {

        // Authorization - user can only cancel their own orders
        if ($order->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action');
        }

        // Validate order can be cancelled
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled');
        }

        DB::beginTransaction();
        try {
            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancellation_reason' => $request->reason,
                'cancelled_at' => now()
            ]);

            // Restore product quantities
            foreach ($order->items as $item) {
                $item->product->increment('quantity', $item->quantity);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Order #'.$order->id.' has been cancelled');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel order: '.$e->getMessage());
        }
    }

}
