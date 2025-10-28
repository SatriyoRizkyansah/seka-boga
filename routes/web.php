<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Check if user is admin, redirect to admin dashboard
    if (Auth::check() && Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Customer Routes (Public)
Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.home');
Route::get('/kategori/{category}', [App\Http\Controllers\CustomerController::class, 'category'])->name('customer.category');
Route::get('/produk/{product}', [App\Http\Controllers\CustomerController::class, 'product'])->name('customer.product');

// Customer Cart Routes (Authenticated)
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{product}', [App\Http\Controllers\CustomerController::class, 'addToCart'])->name('customer.cart.add');
    Route::get('/cart', [App\Http\Controllers\CustomerController::class, 'cart'])->name('customer.cart');
    Route::patch('/cart/update', [App\Http\Controllers\CustomerController::class, 'updateCart'])->name('customer.cart.update');
    Route::delete('/cart/remove', [App\Http\Controllers\CustomerController::class, 'removeFromCart'])->name('customer.cart.remove');
    
    // Checkout Routes
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('customer.checkout');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('customer.checkout.store');
    
    // Payment Routes
    Route::get('/payment/{pesanan}/upload', [App\Http\Controllers\PaymentController::class, 'uploadForm'])->name('customer.payment.upload');
    Route::post('/payment/{pesanan}/upload', [App\Http\Controllers\PaymentController::class, 'upload'])->name('customer.payment.store');
    
    // Orders Routes
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/{pesanan}', [App\Http\Controllers\OrderController::class, 'show'])->name('customer.orders.show');
    Route::patch('/orders/{pesanan}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('customer.orders.cancel');
    
    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\CustomerProfileController::class, 'show'])->name('customer.profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/profile', [App\Http\Controllers\CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::get('/profile/password', [App\Http\Controllers\CustomerProfileController::class, 'editPassword'])->name('customer.profile.password');
    Route::put('/profile/password', [App\Http\Controllers\CustomerProfileController::class, 'updatePassword'])->name('customer.profile.password.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Kategori Produk
    Route::resource('kategori', App\Http\Controllers\Admin\KategoriProdukController::class);
    
    // Produk
    Route::resource('produk', App\Http\Controllers\Admin\ProdukController::class);
    Route::delete('produk/{produk}/gambar/{gambar}', [App\Http\Controllers\Admin\ProdukController::class, 'deleteImage'])
         ->name('produk.gambar.delete');
    
    // Rekening Admin
    Route::resource('rekening', App\Http\Controllers\Admin\RekeningAdminController::class);
});

require __DIR__.'/auth.php';
