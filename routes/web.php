<?php
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboardController;
use App\Http\Controllers\Pembeli\DashboardController as PembeliDashboardController;
// Tambahkan controller lain di sini nanti

// Halaman Awal
Route::get('/', function () {
    return view('welcome');
});

// Rute umum yang bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Tambahkan rute admin lainnya di sini (manajemen user, kategori, dll)
});

// Rute untuk Penjual
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [PenjualDashboardController::class, 'index'])->name('dashboard');
    // Tambahkan rute penjual lainnya di sini (produk, pesanan, dll)
    Route::resource('animals', \App\Http\Controllers\Penjual\AnimalController::class);
});

// Rute untuk Pembeli
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [PembeliDashboardController::class, 'index'])->name('dashboard');
    // Tambahkan rute pembeli lainnya di sini (browse, cart, dll)
});

// Rute Otentikasi dari Breeze
require __DIR__.'/auth.php';