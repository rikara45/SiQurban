<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
    /**
     * Menampilkan daftar pesanan yang masuk (perlu konfirmasi) dan yang sedang berjalan.
     */
    public function index()
    {
        $sellerId = Auth::id();

        // Mengambil pesanan yang perlu konfirmasi
        $incomingOrders = Order::whereHas('items', fn($query) => $query->where('seller_id', $sellerId))
                               ->where('status', 'pending_confirmation')
                               ->with('items.animal', 'buyer')
                               ->latest()->get();

        // Mengambil pesanan yang sedang berjalan
        $ongoingOrders = Order::whereHas('items', fn($query) => $query->where('seller_id', $sellerId))
                                ->whereIn('status', ['processing', 'shipping', 'ready_for_pickup'])
                                ->with('items.animal', 'buyer')
                                ->latest()->paginate(5, ['*'], 'ongoing_page'); // Paginasi terpisah

        // --- QUERY BARU UNTUK RIWAYAT PENJUALAN SELESAI ---
        $completedOrders = Order::whereHas('items', fn($query) => $query->where('seller_id', $sellerId))
                                 ->where('status', 'completed')
                                 ->with('items.animal', 'buyer')
                                 ->latest()->paginate(5, ['*'], 'completed_page'); // Paginasi terpisah

        return view('penjual.orders.index', compact(
            'incomingOrders',
            'ongoingOrders',
            'completedOrders' // Kirim data baru ke view
        ));
    }

    /**
     * Penjual menerima pesanan.
     */
    public function accept(Order $order)
    {
        // Pastikan order ini memang untuk penjual yang login
        if (!$order->items()->where('seller_id', Auth::id())->exists()) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            // Tentukan status selanjutnya berdasarkan metode pengiriman
            $nextStatus = '';
            switch ($order->delivery_method) {
                case 'diantar':
                    $nextStatus = 'shipping';
                    break;
                case 'diambil':
                    $nextStatus = 'ready_for_pickup';
                    break;
                case 'disalurkan':
                    $nextStatus = 'processing'; // Penjual perlu memproses penyaluran
                    break;
            }

            $order->update([
                'status' => $nextStatus,
                'seller_confirmed_at' => now()
            ]);

            // Update semua item milik penjual ini di order tsb menjadi 'accepted'
            $order->items()->where('seller_id', Auth::id())->update(['status' => 'accepted']);
            
            // Update status hewan menjadi 'sold'
            foreach($order->items as $item) {
                if($item->seller_id == Auth::id()) {
                    $item->animal->update(['status' => 'sold']);
                }
            }

            DB::commit();
            return back()->with('success', "Pesanan #{$order->order_number} berhasil diterima.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "Gagal menerima pesanan: " . $e->getMessage());
        }
    }

    /**
     * Penjual menolak pesanan.
     */
    public function reject(Request $request, Order $order)
    {
        $request->validate(['rejection_reason' => 'required|string|max:255']);

        if (!$order->items()->where('seller_id', Auth::id())->exists()) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            $order->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);

            $order->items()->where('seller_id', Auth::id())->update(['status' => 'rejected']);

            // Kembalikan status hewan menjadi 'available'
            foreach($order->items as $item) {
                 if($item->seller_id == Auth::id()) {
                    $item->animal->update(['status' => 'available']);
                }
            }

            DB::commit();
            return back()->with('success', "Pesanan #{$order->order_number} berhasil ditolak.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "Gagal menolak pesanan: " . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail spesifik dari sebuah pesanan untuk penjual.
     */
    public function show(Order $order)
    {
        $sellerId = Auth::id();

        // Otorisasi: Pastikan setidaknya ada satu item dalam order ini
        // yang merupakan milik penjual yang sedang login.
        $this->authorize('view', $order);

        // Eager load relasi yang dibutuhkan untuk view
        $order->load(['buyer', 'items' => function ($query) use ($sellerId) {
            // Hanya muat item yang relevan untuk penjual ini
            $query->where('seller_id', $sellerId)->with('animal');
        }]);

        return view('penjual.orders.show', compact('order'));
    }
}