<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Logic untuk dashboard pembeli bisa ditambahkan di sini
        return view('pembeli.dashboard');
    }
}