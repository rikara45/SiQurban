<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Negotiation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NegotiationController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $negotiations = Negotiation::where('seller_id', Auth::id())
            ->with(['animal', 'buyer'])
            ->latest()
            ->paginate(15);

        return view('penjual.negotiations.index', compact('negotiations'));
    }

    public function accept(Negotiation $negotiation)
    {
        $this->authorize('manage', $negotiation);

        $negotiation->update(['status' => 'accepted']);

        $cart = Session::get('cart', []);
        $animal = $negotiation->animal;

        $cart[$animal->id] = [
            "name" => $animal->name,
            "quantity" => 1,
            "price" => $negotiation->offer_price,
            "photo" => $animal->photos->first()->path ?? null
        ];
        
        // Simplifikasi: Kita tidak bisa langsung memanipulasi session user lain.
        // Sebagai gantinya, kita tandai hewan sebagai 'pending' dan memberitahu penjual.
        // Pembeli akan melihat item di keranjang saat login berikutnya (jika diimplementasikan lebih lanjut).
        $animal->update(['status' => 'pending']);

        // Redirect ke halaman negosiasi, bukan keranjang pembeli.
        return back()->with('success', 'Penawaran diterima! Hewan ini sekarang dipesan untuk pembeli.');
    }

    public function reject(Negotiation $negotiation)
    {
        $this->authorize('manage', $negotiation);
        $negotiation->update(['status' => 'rejected']);
        return back()->with('success', 'Penawaran telah ditolak.');
    }

    public function counter(Request $request, Negotiation $negotiation)
    {
        $this->authorize('manage', $negotiation);

        $request->validate(['counter_price' => 'required|numeric|min:1']);
        
        $negotiation->update([
            'status' => 'countered',
            'counter_price' => $request->counter_price
        ]);
        return back()->with('success', 'Tawaran balik berhasil dikirim.');
    }
}
