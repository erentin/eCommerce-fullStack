<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductShowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartIndexController;
use App\Http\Controllers\CategoryShowController;
use Illuminate\Support\Facades\Route;

Route::get('/',HomeController::class);

Route::get('/cart', CartIndexController::class);

Route::get('/categories/{category:slug}', CategoryShowController::class);

Route::get('/products/{product:slug}',ProductShowController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
