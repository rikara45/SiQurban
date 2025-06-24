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
});

// Rute untuk Penjual
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [PenjualDashboardController::class, 'index'])->name('dashboard');
    // Rute resource animals untuk penjual
    Route::resource('animals', PenjualAnimalController::class);
});

// Rute untuk Pembeli
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [PembeliDashboardController::class, 'index'])->name('dashboard');
    // Tambahkan rute pembeli lainnya di sini (browse, cart, dll)

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{animal}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
});

// Rute Otentikasi dari Breeze
require __DIR__.'/auth.php';