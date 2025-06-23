<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Logic untuk dashboard penjual bisa ditambahkan di sini
        return view('penjual.dashboard');
    }
}