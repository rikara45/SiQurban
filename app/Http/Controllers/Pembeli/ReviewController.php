<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\OrderItem;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $orderItem = OrderItem::with('order')->find($request->order_item_id);

        // Pastikan item ini milik user yang sedang login
        if ($orderItem->order->buyer_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak mereview item ini.');
        }

        // Cek apakah item ini sudah pernah direview
        $existingReview = Review::where('order_item_id', $orderItem->id)->exists();
        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan review untuk item ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'animal_id' => $orderItem->animal_id,
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id, // Tambahkan ini untuk tracking
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas review Anda!');
    }
}