<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4">Pesanan Masuk (Perlu Konfirmasi)</h3>
                    @if($incomingOrders->isEmpty())
                        <p class="text-gray-500">Tidak ada pesanan yang perlu dikonfirmasi saat ini.</p>
                    @else
                        <div class="space-y-4">
                        @foreach($incomingOrders as $order)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold">Order #{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600">Pembeli: {{ $order->buyer->name }}</p>
                                        <p class="text-sm text-gray-600">Tanggal: {{ $order->created_at->format('d M Y') }}</p>
                                        <p class="text-sm text-gray-600">Metode: <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->delivery_method)) }}</span></p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('penjual.orders.accept', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin MENERIMA pesanan ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600">Terima</button>
                                        </form>
                                        <button onclick="document.getElementById('reject-form-{{$order->id}}').classList.remove('hidden')" class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600">Tolak</button>
                                    </div>
                                </div>
                                <form action="{{ route('penjual.orders.reject', $order) }}" method="POST" id="reject-form-{{$order->id}}" class="hidden mt-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="rejection_reason" class="text-sm">Alasan Penolakan:</label>
                                    <input type="text" name="rejection_reason" required class="w-full text-sm border-gray-300 rounded-md" placeholder="Contoh: Stok habis">
                                    <button type="submit" class="mt-1 px-2 py-1 bg-red-500 text-white text-xs rounded-md">Kirim Penolakan</button>
                                </form>
                            </div>
                        @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4">Pesanan Sedang Berjalan</h3>
                     @if($ongoingOrders->isEmpty())
                        <p class="text-gray-500">Tidak ada pesanan yang sedang berjalan.</p>
                    @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembeli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($ongoingOrders as $order)
                            <tr>
                                <td class="px-6 py-4">{{ $order->order_number }}</td>
                                <td class="px-6 py-4">{{ $order->buyer->name }}</td>
                                <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $order->delivery_method)) }}</td>
                                <td class="px-6 py-4">
                                     <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    Menunggu konfirmasi pembeli
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $ongoingOrders->links() }}
                    </div>
                    @endif
                 </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4">Riwayat Penjualan (Selesai)</h3>
                     @if($completedOrders->isEmpty())
                        <p class="text-gray-500">Belum ada penjualan yang selesai.</p>
                    @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembeli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($completedOrders as $order)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-6 py-4">{{ $order->buyer->name }}</td>
                                <td class="px-6 py-4">{{ $order->buyer_confirmed_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                     <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('penjual.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{-- Memanggil paginasi untuk riwayat selesai --}}
                        {{ $completedOrders->links('pagination::tailwind') }}
                    </div>
                    @endif
                 </div>
            </div>

        </div>
    </div>
</x-app-layout>