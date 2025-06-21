<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
