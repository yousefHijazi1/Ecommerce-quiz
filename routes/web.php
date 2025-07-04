<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
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

//Home Controller Routes
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/home', 'roleCheck')->name('role-check');
});

Route::get('/products',[ProductController::class, 'index'])->name('products');




//Cart Controller Routes
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart');
    Route::get('/cart-items', 'getCartItems')->name('cart-items');
    Route::post('/update-cart', 'updateCart')->name('cart.update');
    Route::post('/cart/add', 'add')->name('cart.add');
    Route::delete('/cart/{id}', 'remove')->name('cart.remove');
});



Route::middleware('auth')->group(function () {
    //Order Controller Routes
    Route::controller(OrderController::class)->group(function () {
        Route::post('/orders', 'store')->name('orders.store');
        Route::get('/orders/{order}', 'show')->name('orders.show');
        Route::get('/orders-display', 'index')->name('orders.display');
        Route::patch('/orders/{order}/cancel', 'cancel')->name('orders.cancel');
    });

    //Admin Controller Routes
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'index')->name('admin.dashboard');
        Route::get('/products-display', 'displayProducts')->name('products.display');
        Route::get('/users-display', 'displayUsers')->name('users.display');
        Route::get('/admin-orders-display', 'displayOrders')->name('admin.orders.display');
        Route::get('/product-create','createProduct')->name('product.create');
        Route::post('/product-store','storeProduct')->name('product.store');
        Route::get('/user-create','createUser')->name('user.create');
        Route::post('/user-store','storeUser')->name('user.store');
        Route::patch('/orders/{order}/status','updateStatus')->name('admin.orders.update-status');
    });

});
