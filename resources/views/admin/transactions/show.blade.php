<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Transaksi - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .glass { backdrop-filter: blur(16px); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen gradient-bg">
        @include('layouts.navigation')
        <header>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-2xl text-white leading-tight">
                    {{ __('Detail Transaksi: #') . $order->order_number }}
                </h2>
            </div>
        </header>
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="glass overflow-hidden shadow-lg rounded-2xl">
                        <div class="p-6 text-white">
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-white mb-2">Ringkasan Pesanan</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-300">
                                    <div><strong>Nomor Order:</strong> <span class="text-white">{{ $order->order_number }}</span></div>
                                    <div><strong>Tanggal Order:</strong> <span class="text-white">{{ $order->created_at->format('d M Y, H:i') }}</span></div>
                                    <div><strong>Pembeli:</strong> <span class="text-white">{{ $order->buyer->name }} ({{ $order->buyer->email }})</span></div>
                                    <div><strong>Status:</strong> <span class="font-semibold text-blue-300">{{ str_replace('_', ' ', $order->status) }}</span></div>
                                    <div class="md:col-span-2"><strong>Total Transaksi:</strong> <span class="font-bold text-lg text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-white mb-2">Item Pesanan</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 divide-opacity-20">
                                        <thead class="bg-transparent">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Hewan</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Penjual</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 divide-opacity-20">
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $item->animal->name ?? 'Hewan Dihapus' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $item->animal->user->name ?? 'Penjual Dihapus' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-6 border-t border-white border-opacity-20 pt-4">
                                <a href="{{ route('admin.transactions.index') }}" class="text-indigo-300 hover:text-white">&larr; Kembali ke Riwayat Transaksi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>