<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    return redirect('/');
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products',[ProductController::class, 'index'])->name('products');


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

Route::get('/cart-items', [CartController::class, 'getCartItems'])->name('cart-items');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');


Route::middleware('auth')->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders-display', [OrderController::class, 'index'])->name('orders.display');

});
