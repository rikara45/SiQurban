<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Animal;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil user yang sedang login
        $user = Auth::user();

        // Menghitung statistik dasar
        $totalAnimals = $user->animals()->count();
        $animalsAvailable = $user->animals()->where('status', 'available')->count();
        $animalsSold = $user->animals()->where('status', 'sold')->count();
        
        // Menghitung statistik penjualan
        // Kita menggunakan relasi 'sales' yang baru dibuat
        $totalSales = $user->sales()->count();
        $totalEarnings = $user->sales()->sum('price');

        // Mengambil beberapa pesanan terbaru untuk ditampilkan
        $recentSales = $user->sales()
                            ->with(['animal', 'order.buyer']) // Eager loading untuk performa
                            ->latest() // Urutkan dari yang terbaru
                            ->take(5) // Ambil 5 data teratas
                            ->get();

        // Mengirim semua data ke view
        return view('penjual.dashboard', compact(
            'totalAnimals',
            'animalsAvailable',
            'animalsSold',
            'totalSales',
            'totalEarnings',
            'recentSales'
        ));
    }
}