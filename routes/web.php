<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Pembeli\DashboardController as PembeliDashboardController;
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboardController;
use App\Http\Controllers\Penjual\AnimalController as PenjualAnimalController;
use App\Http\Controllers\Pembeli\CartController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnimalController as AdminAnimalController;
use App\Http\Controllers\Admin\TransactionController;

// Halaman Awal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk menampilkan detail hewan (bisa diakses semua role, termasuk guest)
Route::get('/animals/{animal}', [AnimalController::class, 'show'])->name('animals.show');

// Rute untuk semua role yang sudah login
Route::middleware(['auth'])->get('/dashboard', function () {
    // Redirect ke dashboard sesuai role, atau tampilkan dashboard umum
    return view('dashboard');
})->name('dashboard');

// Rute umum yang bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);

    // Manajemen User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');

    // Manajemen Hewan
    Route::get('/animals', [AdminAnimalController::class, 'index'])->name('animals.index');

    // Rute untuk Transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{order}', [TransactionController::class, 'show'])->name('transactions.show');
});

// Rute untuk Penjual
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [PenjualDashboardController::class, 'index'])->name('dashboard');
    // Rute resource animals untuk penjual
    Route::resource('animals', PenjualAnimalController::class);

    // Penjualan
    Route::get('/orders', [\App\Http\Controllers\Penjual\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Penjual\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/accept', [\App\Http\Controllers\Penjual\OrderController::class, 'accept'])->name('orders.accept');
    Route::patch('/orders/{order}/reject', [\App\Http\Controllers\Penjual\OrderController::class, 'reject'])->name('orders.reject');

    // Negotiation Routes
    Route::get('/negotiations', [\App\Http\Controllers\Penjual\NegotiationController::class, 'index'])->name('negotiations.index');
    Route::patch('/negotiations/{negotiation}/accept', [\App\Http\Controllers\Penjual\NegotiationController::class, 'accept'])->name('negotiations.accept');
    Route::patch('/negotiations/{negotiation}/reject', [\App\Http\Controllers\Penjual\NegotiationController::class, 'reject'])->name('negotiations.reject');
    Route::patch('/negotiations/{negotiation}/counter', [\App\Http\Controllers\Penjual\NegotiationController::class, 'counter'])->name('negotiations.counter');
});

// Rute untuk Pembeli
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [PembeliDashboardController::class, 'index'])->name('dashboard');
    
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{animal}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout Routes
    Route::post('/checkout', [\App\Http\Controllers\Pembeli\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [\App\Http\Controllers\Pembeli\CheckoutController::class, 'success'])->name('checkout.success');

    // Order History
    Route::get('/orders', [\App\Http\Controllers\Pembeli\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Pembeli\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/complete', [\App\Http\Controllers\Pembeli\OrderController::class, 'complete'])->name('orders.complete');
    // Review Route
    Route::post('/review', [\App\Http\Controllers\Pembeli\ReviewController::class, 'store'])->name('review.store');

    // Negotiation Route
    Route::get('/negotiations', [\App\Http\Controllers\Pembeli\NegotiationController::class, 'index'])->name('negotiations.index');
    Route::post('/negotiations/store', [\App\Http\Controllers\Pembeli\NegotiationController::class, 'store'])->name('negotiations.store');
    Route::patch('/negotiations/{negotiation}/accept-counter', [\App\Http\Controllers\Pembeli\NegotiationController::class, 'acceptCounter'])->name('negotiations.acceptCounter');
    Route::patch('/negotiations/{negotiation}/reject-counter', [\App\Http\Controllers\Pembeli\NegotiationController::class, 'rejectCounter'])->name('negotiations.rejectCounter');
});

// Rute Otentikasi dari Breeze
require __DIR__.'/auth.php';