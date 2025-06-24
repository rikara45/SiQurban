<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Animal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Memproses checkout dan menyimpan order.
     */
    public function store(Request $request)
    {
        $cartItems = session('cart', []);
        $user = Auth::user();

        $request->validate([
            'delivery_method' => 'required|in:diantar,diambil,disalurkan',
        ]);

        if (empty($cartItems)) {
            return redirect()->route('pembeli.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        DB::beginTransaction();
        try {
            $totalAmount = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'buyer_id' => $user->id,
                'order_number' => 'SQ-' . strtoupper(Str::random(10)),
                'total_amount' => $totalAmount,
                'delivery_method' => $request->delivery_method,
                'status' => 'pending_confirmation',
            ]);

            foreach ($cartItems as $animal_id => $item) {
                $animal = Animal::find($animal_id);
                
                // --- INI BAGIAN YANG DIPERBAIKI ---
                if (!$animal || !in_array($animal->status, ['available', 'pending'])) {
                    throw new \Exception("Hewan '{$item['name']}' tidak lagi tersedia.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'animal_id' => $animal_id,
                    'seller_id' => $animal->user_id,
                    'price' => $item['price'],
                    'status' => 'pending'
                ]);

                // Setelah masuk ke order, status hewan harus 'pending'
                // untuk menunggu konfirmasi penjual.
                $animal->update(['status' => 'pending']);
            }

            DB::commit();
            Session::forget('cart');

            return redirect()->route('pembeli.checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pembeli.cart.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman konfirmasi setelah checkout berhasil.
     */
    public function success(Order $order)
    {
        // Pastikan hanya pembeli yang benar yang bisa melihat halaman sukses ini
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        return view('pembeli.checkout.success', compact('order'));
    }
}