<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Frontend\ComicController as FrontComicController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================================
// RUTE PUBLIK (Bisa diakses tanpa login)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/komik/{id}', [FrontComicController::class, 'show'])->name('comics.show');


// ==========================================
// RUTE DASHBOARD (Pengalihan setelah login)
// ==========================================
Route::get('/dashboard', function () {
    // Jika admin atau staff, arahkan ke dashboard panel
    if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
        return redirect()->route('admin.dashboard');
    }
    // Jika customer, kembalikan ke home dengan pesan sukses
    return redirect()->route('home')->with('success', 'Berhasil masuk ke Mangaverse!');
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// RUTE CUSTOMER (Wajib Login)
// ==========================================
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keranjang Belanja
    Route::get('/keranjang', [\App\Http\Controllers\Frontend\CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah/{comic_id}', [\App\Http\Controllers\Frontend\CartController::class, 'store'])->name('cart.store');
    Route::delete('/keranjang/hapus/{id}', [\App\Http\Controllers\Frontend\CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [\App\Http\Controllers\Frontend\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/proses', [\App\Http\Controllers\Frontend\CheckoutController::class, 'process'])->name('checkout.process');

    // Riwayat Pesanan & Pembayaran
    Route::get('/pesanan-saya', [\App\Http\Controllers\Frontend\OrderController::class, 'index'])->name('customer.orders');
    Route::get('/pesanan-saya/{id}', [\App\Http\Controllers\Frontend\OrderController::class, 'show'])->name('customer.orders.show');
    Route::post('/pesanan-saya/{id}/bayar', [\App\Http\Controllers\Frontend\OrderController::class, 'pay'])->name('customer.orders.pay');

    // Ulasan Komik
    Route::post('/comics/{comic_id}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});


// ==========================================
// RUTE ADMIN (Wajib Login & Role Admin/Staff)
// ==========================================
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Komik
    Route::resource('comics', \App\Http\Controllers\Admin\ComicController::class);

    // Laporan Penjualan (Harus di atas resource orders)
    Route::get('/orders/laporan', [\App\Http\Controllers\Admin\OrderController::class, 'report'])->name('orders.report');

    // Manajemen Pesanan
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);

    // Manajemen Stok
    Route::get('/stok', [\App\Http\Controllers\Admin\StockController::class, 'index'])->name('stock.index');
    Route::put('/stok/{id}', [\App\Http\Controllers\Admin\StockController::class, 'update'])->name('stock.update');
    
    // Pengarang & Penerbit
    Route::get('/pengarang-penerbit', function() {
        // Tarik data komik beserta relasinya
        $comics = \App\Models\Comic::with(['author', 'publisher'])->get();
        
        // Ekstrak pengarang dan penerbit yang unik (tidak ganda)
        $authors = $comics->pluck('author')->filter()->unique('id');
        $publishers = $comics->pluck('publisher')->filter()->unique('id');
        
        return view('admin.comics.authors', compact('authors', 'publishers'));
    })->name('authors.index');
});

require __DIR__.'/auth.php';