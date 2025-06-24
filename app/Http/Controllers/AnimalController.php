<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function show(Animal $animal)
    {
        $animal->load(['category', 'user', 'photos', 'reviews.user']);
        return view('animals.show', compact('animal'));
    }
}