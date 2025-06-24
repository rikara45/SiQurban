<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of all animals.
     */
    public function index(Request $request)
    {
        $query = Animal::with(['category', 'user']);

        // You can add filters here similar to the user management if needed
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $animals = $query->latest()->paginate(10);

        return view('admin.animals.index', compact('animals'));
    }
}