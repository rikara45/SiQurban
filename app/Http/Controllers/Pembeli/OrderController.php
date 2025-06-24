<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // Pastikan model Order di-import

class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan milik pembeli yang sedang login.
     */
    public function index()
    {
        $orders = Auth::user()->orders()
                        ->with('items.animal') // Eager load untuk efisiensi
                        ->latest()
                        ->paginate(10);
        
        return view('pembeli.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show($orderId)
    {
        $order = Auth::user()->orders()
                      ->with('items.animal.user', 'items.animal.category') // Load relasi penjual juga
                      ->findOrFail($orderId);

        return view('pembeli.orders.show', compact('order'));
    }

    /**
     * Pembeli mengkonfirmasi bahwa pesanan telah diterima/selesai.
     */
    public function complete(Order $order)
    {
        // Validasi: Pastikan order ini milik user yang sedang login
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Validasi: Pastikan status order relevan untuk diselesaikan
        if (!in_array($order->status, ['shipping', 'ready_for_pickup', 'processing'])) {
            return back()->with('error', 'Pesanan ini tidak dapat diselesaikan saat ini.');
        }

        $order->update([
            'status' => 'completed',
            'buyer_confirmed_at' => now()
        ]);

        return redirect()->route('pembeli.orders.show', $order)->with('success', 'Pesanan telah ditandai sebagai selesai. Terima kasih!');
    }
}