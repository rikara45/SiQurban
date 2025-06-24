<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Animal;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data statistik.
     */
    public function index()
    {
        // Statistik Pengguna
        $totalUsers = User::count();
        $totalSellers = User::role('penjual')->count();
        $totalBuyers = User::role('pembeli')->count();

        // Statistik Transaksi & Hewan
        $totalOrders = Order::count();
        $totalAnimals = Animal::count();
        $totalRevenue = OrderItem::sum('price');

        // Data untuk ditampilkan di tabel aktivitas terbaru
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSellers',
            'totalBuyers',
            'totalOrders',
            'totalAnimals',
            'totalRevenue',
            'recentUsers'
        ));
    }
}
