<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Animal::query()
            ->whereIn('status', ['available', 'sold']) // Ambil yang available DAN sold
            ->with(['category', 'photos']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Tambahkan pengurutan agar 'available' selalu di atas
        $animals = $query->orderByRaw("FIELD(status, 'available', 'sold')")
                         ->latest()
                         ->paginate(12);
                         
        $categories = Category::all();

        return view('welcome', compact('animals', 'categories'));
    }
}