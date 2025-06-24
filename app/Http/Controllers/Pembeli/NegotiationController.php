<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Negotiation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NegotiationController extends Controller
{
    /**
     * Menampilkan daftar negosiasi milik pembeli.
     */
    public function index()
    {
        $negotiations = Negotiation::where('buyer_id', Auth::id())
            ->with(['animal', 'seller'])
            ->latest()
            ->paginate(15);
            
        return view('pembeli.negotiations.index', compact('negotiations'));
    }

    /**
     * Menyimpan penawaran baru dari pembeli.
     */
    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'offer_price' => 'required|numeric|min:1',
        ]);

        $animal = Animal::find($request->animal_id);
        $buyer = Auth::user();

        // Cek apakah hewan masih tersedia
        if ($animal->status !== 'available') {
            return back()->with('error', 'Hewan ini sudah tidak tersedia untuk dinegosiasi.');
        }

        // Cek apakah sudah ada negosiasi aktif dari pembeli ini untuk hewan ini
        $existingNego = Negotiation::where('animal_id', $animal->id)
            ->where('buyer_id', $buyer->id)
            ->whereIn('status', ['pending', 'countered'])
            ->first();

        if ($existingNego) {
            return back()->with('error', 'Anda sudah memiliki penawaran aktif untuk hewan ini.');
        }

        Negotiation::create([
            'animal_id' => $animal->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $animal->user_id,
            'offer_price' => $request->offer_price,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Penawaran Anda berhasil dikirim ke penjual.');
    }

    /**
     * Pembeli menerima tawaran balik dari penjual.
     */
    public function acceptCounter(Negotiation $negotiation)
    {
        // Pastikan negosiasi ini untuk user yang login
        if ($negotiation->buyer_id !== Auth::id()) {
            abort(403);
        }

        $negotiation->update(['status' => 'accepted']);

        // Tambahkan hewan ke keranjang dengan harga counter
        $cart = Session::get('cart', []);
        $animal = $negotiation->animal;
        $animal->update(['status' => 'pending']); // Tandai hewan dipesan

        $cart[$animal->id] = [
            "name" => $animal->name,
            "quantity" => 1,
            "price" => $negotiation->counter_price, // Gunakan harga counter
            "photo" => $animal->photos->first()->path ?? null,
        ];

        Session::put('cart', $cart);

        // Arahkan pembeli langsung ke keranjang mereka
        return redirect()->route('pembeli.cart.index')->with('success', 'Tawaran diterima! Hewan telah ditambahkan ke keranjang Anda.');
    }

    /**
     * Pembeli menolak tawaran balik dari penjual.
     */
    public function rejectCounter(Negotiation $negotiation)
    {
        if ($negotiation->buyer_id !== Auth::id()) {
            abort(403);
        }

        $negotiation->update(['status' => 'rejected']);

        return back()->with('success', 'Anda telah menolak tawaran balik dari penjual.');
    }
}
