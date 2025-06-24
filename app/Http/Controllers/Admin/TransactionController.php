<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions/orders.
     */
    public function index()
    {
        $orders = Order::with('buyer')->latest()->paginate(10);
        return view('admin.transactions.index', compact('orders'));
    }

    /**
     * Display the specified transaction/order.
     */
    public function show(Order $order)
    {
        // Eager load relationships for efficiency
        $order->load('buyer', 'items.animal.user');
        return view('admin.transactions.show', compact('order'));
    }
}