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
