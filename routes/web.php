<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductShowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartIndexController;
use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\CheckoutIndexController;
use App\Http\Controllers\OrderConfirmationIndexController;
use App\Http\Controllers\OrderIndexController;
use Illuminate\Support\Facades\Route;


Route::get('/',HomeController::class)->name('home');

Route::get('/cart', CartIndexController::class)->name('cart');

Route::get('/checkout',CheckoutIndexController::class);

Route::get('/categories/{category:slug}', CategoryShowController::class);

Route::get('/products/{product:slug}',ProductShowController::class);

Route::get('/orders/{order:uuid}/confirmation',OrderConfirmationIndexController::class)->name('orders.confirmation');

Route::get('/orders',OrderIndexController::class)->name('orders');

// ADMIN ROUTES
Route::get('/admin',[AdminController::class,'index'])->name('admin-index')->middleware('admin');
Route::get('/admin/create',[AdminController::class,'create'])->name('admin-create');
Route::post('/admin/store',[AdminController::class,'store'])->name('admin-product-store');
Route::post('/admin/store/variation',[AdminController::class,'storeVariation'])->name('admin-variation-store');
Route::post('/admin/store/stock',[AdminController::class,'stockStore'])->name('admin-stock-store');
Route::get('/admin/orders',[AdminController::class,'orders'])->name('admin-orders');
Route::get('/admin/orders/{order:id}',[AdminController::class,'showOrder'])->name('admin-order');

Route::get('/admin/users',[AdminController::class,'users'])->name('admin-users');
Route::get('/admin/products',[AdminProductsController::class,'index'])->name('admin-products');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
