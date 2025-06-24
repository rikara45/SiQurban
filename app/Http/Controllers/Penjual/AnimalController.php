<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan daftar hewan milik user yang sedang login
        $animals = Auth::user()->animals()->with('category')->latest()->paginate(10);
        return view('penjual.animals.index', compact('animals'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah hewan baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('penjual.animals.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data hewan baru dari form.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'age' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'photos' => 'required|array|min:1|max:3',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi setiap file foto
        ]);

        // Membuat data hewan baru yang terhubung dengan user (penjual)
        $animal = Auth::user()->animals()->create($request->only('name', 'category_id', 'price', 'weight', 'age', 'description'));

        // Jika ada file foto yang di-upload
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // Simpan foto ke folder 'public/animal_photos'
                $path = $photo->store('animal_photos', 'public');
                // Buat record baru di tabel animal_photos
                $animal->photos()->create(['path' => $path]);
            }
        }

        // Arahkan kembali ke halaman daftar hewan dengan pesan sukses
        return redirect()->route('penjual.animals.index')->with('success', 'Hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu hewan spesifik.
     */
    public function show(Animal $animal)
    {
        // Memastikan penjual hanya bisa melihat detail hewannya sendiri.
        // Jika ID user di hewan tidak sama dengan ID user yang login, tampilkan error 403 (Forbidden).
        if ($animal->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }

        // Load relasi foto untuk ditampilkan di view
        $animal->load('photos', 'category');

        return view('penjual.animals.show', compact('animal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        if ($animal->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('penjual.animals.edit', compact('animal', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal)
    {
        if ($animal->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'age' => 'required|integer|min:0',
            'status' => 'required|in:available,sold',
            'description' => 'nullable|string',
        ]);
        
        $animal->update($request->all());

        return redirect()->route('penjual.animals.index')->with('success', 'Data hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        if ($animal->user_id !== Auth::id()) {
            abort(403);
        }

        foreach ($animal->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }
        
        $animal->delete();

        return redirect()->route('penjual.animals.index')->with('success', 'Hewan berhasil dihapus.');
    }
}
