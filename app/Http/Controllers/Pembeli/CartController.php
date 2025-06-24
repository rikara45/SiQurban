<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $total = collect($cartItems)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('pembeli.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Animal $animal)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$animal->id])) {
            // Jika sudah ada, mungkin tidak perlu ditambah (karena hewan unik)
            // atau bisa ditambahkan logic lain
        } else {
            $cart[$animal->id] = [
                "name" => $animal->name,
                "quantity" => 1,
                "price" => $animal->price,
                "photo" => $animal->photos->first()->path ?? null
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Hewan berhasil ditambahkan ke keranjang!');
    }

    public function remove($cartItemId)
    {
        $cart = session()->get('cart');
        if(isset($cart[$cartItemId])) {
            unset($cart[$cartItemId]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Hewan berhasil dihapus dari keranjang.');
    }
}