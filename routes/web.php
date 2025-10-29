<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Profile routes for admin (keeping compatibility)
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
    
    // Test Route untuk debugging
    Route::get('/checkout-test', function() {
        $user = Auth::user();
        $cartItems = \App\Models\KeranjangBelanja::where('id_customer', $user->id)->with('produk')->get();
        $total = $cartItems->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });
        return view('customer.checkout.test', compact('user', 'cartItems', 'total'));
    })->name('checkout.test');
    
    // Payment Routes
    Route::get('/payment/{pesanan}/upload', [App\Http\Controllers\PaymentController::class, 'uploadForm'])->name('customer.payment.upload');
    Route::post('/payment/{pesanan}/upload', [App\Http\Controllers\PaymentController::class, 'upload'])->name('customer.payment.store');
    
    // Orders Routes
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/{pesanan}', [App\Http\Controllers\OrderController::class, 'show'])->name('customer.orders.show');
    Route::patch('/orders/{pesanan}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('customer.orders.cancel');
    
    // Customer Profile Routes
    Route::get('/customer/profile', [App\Http\Controllers\CustomerProfileController::class, 'show'])->name('customer.profile.show');
    Route::get('/customer/profile/edit', [App\Http\Controllers\CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/customer/profile', [App\Http\Controllers\CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::get('/customer/profile/password', [App\Http\Controllers\CustomerProfileController::class, 'editPassword'])->name('customer.profile.password');
    Route::put('/customer/profile/password', [App\Http\Controllers\CustomerProfileController::class, 'updatePassword'])->name('customer.profile.password.update');
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
    
    // Pesanan
    Route::get('pesanan', [App\Http\Controllers\Admin\AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('pesanan/{pesanan}', [App\Http\Controllers\Admin\AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::patch('pesanan/{pesanan}/status', [App\Http\Controllers\Admin\AdminPesananController::class, 'updateStatus'])->name('pesanan.update-status');
    Route::patch('pesanan/{pesanan}/payment', [App\Http\Controllers\Admin\AdminPesananController::class, 'confirmPayment'])->name('pesanan.confirm-payment');
});

require __DIR__.'/auth.php';
