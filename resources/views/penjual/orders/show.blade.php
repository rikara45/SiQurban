<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Penjualan: #') . $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 pb-4 border-b">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Pesanan</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div><strong>Nomor Order:</strong> {{ $order->order_number }}</div>
                            <div><strong>Tanggal Order:</strong> {{ $order->created_at->format('d M Y, H:i') }}</div>
                            <div><strong>Nama Pembeli:</strong> {{ $order->buyer->name }}</div>
                            <div><strong>Email Pembeli:</strong> {{ $order->buyer->email }}</div>
                            <div><strong>Metode Pengiriman:</strong> <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->delivery_method)) }}</span></div>
                            <div><strong>Status:</strong> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ ucfirst($order->status) }}</span></div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Hewan yang Terjual dalam Transaksi Ini</h3>
                        <div class="overflow-x-auto border rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Hewan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Jual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr class="bg-white">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->animal->name ?? 'Hewan Dihapus' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <a href="{{ route('penjual.orders.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Manajemen Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>