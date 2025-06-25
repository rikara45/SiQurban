<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Transaksi - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            /* Latar belakang netral */
        }

        .content-card {
            background-color: #d9ead3;
            /* Warna hijau terang */
            border-radius: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{-- PERUBAHAN: Teks header menjadi hitam --}}
                <h2 class="font-semibold text-2xl text-black leading-tight">
                    {{ __('Detail Transaksi: #') . $order->order_number }}
                </h2>
            </div>
        </header>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{-- PERUBAHAN: Menggunakan .content-card --}}
                    <div class="content-card overflow-hidden">
                        <div class="p-6 text-black">
                            <div class="mb-6">
                                {{-- PERUBAHAN: Teks sub-judul menjadi hitam --}}
                                <h3 class="text-lg font-medium text-black mb-2">Ringkasan Pesanan</h3>
                                {{-- PERUBAHAN: Teks detail menjadi hitam --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-black">
                                    <div><strong>Nomor Order:</strong> <span>{{ $order->order_number }}</span></div>
                                    <div><strong>Tanggal Order:</strong>
                                        <span>{{ $order->created_at->format('d M Y, H:i') }}</span></div>
                                    <div><strong>Pembeli:</strong> <span>{{ $order->buyer->name }}
                                            ({{ $order->buyer->email }})</span></div>
                                    <div><strong>Status:</strong> <span
                                            class="font-semibold text-blue-600">{{ str_replace('_', ' ', $order->status) }}</span>
                                    </div>
                                    <div class="md:col-span-2"><strong>Total Transaksi:</strong> <span
                                            class="font-bold text-lg">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-black mb-2">Item Pesanan</h3>
                                <div class="overflow-x-auto">
                                    {{-- PERUBAHAN: Tabel dengan border hitam --}}
                                    <table class="min-w-full border-collapse border border-black">
                                        <thead>
                                            <tr>
                                                {{-- PERUBAHAN: Header tabel dengan border dan teks hitam --}}
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                    Hewan</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                    Penjual</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                    Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    {{-- PERUBAHAN: Sel tabel dengan border dan teks hitam --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm border border-black">
                                                        {{ $item->animal->name ?? 'Hewan Dihapus' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm border border-black">
                                                        {{ $item->animal->user->name ?? 'Penjual Dihapus' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm border border-black">Rp
                                                        {{ number_format($item->price, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- PERUBAHAN: Garis pemisah dan tautan disesuaikan --}}
                            <div class="mt-6 border-t border-black pt-4">
                                <a href="{{ route('admin.transactions.index') }}"
                                    class="text-blue-600 hover:text-blue-800">&larr; Kembali ke Riwayat Transaksi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>