<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnimalController extends Controller
{
    public function index()
    {
        $animals = Auth::user()->animals()->with('category')->latest()->paginate(10);
        return view('penjual.animals.index', compact('animals'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('penjual.animals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'age' => 'required|integer|min:1',
            'weight' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photos' => 'nullable|array|max:3',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $animal = Auth::user()->animals()->create($request->only('name', 'category_id', 'age', 'weight', 'price', 'description'));

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('animal-photos', 'public');
                $animal->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('penjual.animals.index')->with('success', 'Hewan berhasil ditambahkan.');
    }

    public function show(Animal $animal)
    {
         // Hanya bisa melihat produk sendiri
        if ($animal->user_id !== Auth::id()) {
            abort(403);
        }
        return view('penjual.animals.show', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        if ($animal->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('penjual.animals.edit', compact('animal', 'categories'));
    }

    public function update(Request $request, Animal $animal)
    {
        if ($animal->user_id !== Auth::id()) {
            abort(403);
        }
        // Logic validasi dan update mirip seperti store()
        $request->validate([/*...validasi...*/]);
        $animal->update($request->only('name', 'category_id', 'age', 'weight', 'price', 'description'));

        // Handle update foto jika ada
        return redirect()->route('penjual.animals.index')->with('success', 'Data hewan berhasil diperbarui.');
    }

    public function destroy(Animal $animal)
    {
        if ($animal->user_id !== Auth::id()) {
            abort(403);
        }
        $animal->delete();
        return redirect()->route('penjual.animals.index')->with('success', 'Data hewan berhasil dihapus.');
    }
}