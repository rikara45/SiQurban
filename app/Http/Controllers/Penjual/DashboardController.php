<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Animal;      
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik Hewan
        $totalAnimals = $user->animals()->count();
        $animalsAvailable = $user->animals()->where('status', 'available')->count();
        // Status 'sold' menandakan hewan sudah di-commit untuk penjualan setelah di-acc penjual. Ini sudah benar.
        $animalsSold = $user->animals()->where('status', 'sold')->count();
        
        // --- PERBAIKI LOGIKA STATISTIK PENJUALAN DI SINI ---
        
        // Hanya hitung item dari order yang sudah 'completed'
        $completedSales = $user->sales()->whereHas('order', function ($query) {
            $query->where('status', 'completed');
        });

        // Kloning query agar bisa digunakan untuk count dan sum tanpa eksekusi ulang
        $totalSales = (clone $completedSales)->count();
        $totalEarnings = (clone $completedSales)->sum('price');
        
        // Ambil 5 penjualan terbaru yang sudah selesai
        $recentSales = $user->sales()
                            ->whereHas('order', function ($query) {
                                $query->where('status', 'completed');
                            })
                            ->with(['animal', 'order.buyer'])
                            ->latest()
                            ->take(5)
                            ->get();

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