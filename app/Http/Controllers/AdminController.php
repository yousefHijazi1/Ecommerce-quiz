<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $recentUsers = User::latest()->take(5)->get();
        $recentOrders = Order::latest()->take(5)->get();
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total');

        return view('admin.index', compact(
            'recentUsers',
            'recentOrders',
            'totalProducts',
            'totalUsers',
            'totalOrders',
            'totalRevenue'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function displayProducts(){
        $products = Product::paginate(9);
        return view('admin.products-display', compact('products'));
    }

    public function displayUsers(){
        $users = User::paginate(9);
        return view('admin.users-display', compact('users'));
    }

    public function displayOrders(){
        $orders = Order::with('user')->paginate(9);

        return view('admin.orders-display', compact('orders'));
    }


    public function createProduct() {
        return view('admin.create-product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeProduct(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->price = $request->input('price');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put($imageName, file_get_contents($image));
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('product.create')->with('success', 'Product created successfully!');
    }

    public function createUser() {
        return view('admin.create-user');
    }

    public function storeUser(Request $request) {
        // Validate the form data
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'phone_number' => 'required',
        ]);

        $input['password'] = Hash::make($input['password']);
        $input['role'] = 'user';

        $user = User::create($input);

        if(!$user){
            return back()->withErrors('User creation failed.')->withInput();
        }

        return redirect()->route('user.create')->with('success', 'User created successfully!');
    }

    public function updateStatus(Request $request, Order $order){
        $validStatuses = ['processing', 'shipped', 'delivered', 'cancelled'];

        $request->validate([
            'status' => 'required|in:' . implode(',', $validStatuses)
        ]);

        try {
            DB::beginTransaction();

            $previousStatus = $order->status;
            $newStatus = $request->status;

            // Update order status
            $order->update(['status' => $newStatus]);

            // If cancelling, restore product quantities
            if ($newStatus === 'cancelled' && $previousStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    $item->product->increment('quantity', $item->quantity);
                }
            }

            DB::commit();

            return back()->with('success', "Order #{$order->id} status updated to " . ucfirst($newStatus));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order status update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update order status');
        }
    }

}
