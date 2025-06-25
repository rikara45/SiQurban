<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pesanan: #') . $order->order_number }}
            </h2>

            {{-- TOMBOL KONFIRMASI BARU --}}
            @if(in_array($order->status, ['shipping', 'ready_for_pickup', 'processing']))
                <form action="{{ route('pembeli.orders.complete', $order) }}" method="POST"
                    onsubmit="return confirm('Dengan ini, Anda mengkonfirmasi bahwa transaksi telah selesai sesuai kesepakatan. Lanjutkan?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-md hover:bg-green-700">
                        Konfirmasi Pesanan Selesai
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div><strong>Nomor Order:</strong> {{ $order->order_number }}</div>
                        <div><strong>Tanggal Order:</strong> {{ $order->created_at->format('d M Y, H:i') }}</div>
                        <div><strong>Status:</strong> <span
                                class="font-semibold text-green-600">{{ str_replace('_', ' ', $order->status) }}</span>
                        </div>
                        <div class="md:col-span-2"><strong>Total Transaksi:</strong> <span class="font-bold text-lg">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                    </div>

                    <h3 class="text-lg font-medium mb-2">Item yang Dibeli</h3>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hewan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penjual
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->animal->name ?? 'Hewan Dihapus' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $item->animal->user->name ?? 'Penjual Dihapus' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</td>
                                    </tr>

                                    {{-- BUNGKUS SELURUH BLOK REVIEW DENGAN KONDISI INI --}}
                                    @if($order->status == 'completed')
                                        @if(is_null($item->review))
                                            <tr class="bg-gray-50">
                                                <td colspan="3" class="px-6 py-4">
                                                    <form action="{{ route('pembeli.review.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                                                        <h4 class="font-semibold text-sm mb-2">Berikan Ulasan Anda:</h4>
                                                        <div class="flex items-center space-x-4">
                                                            <div>
                                                                <label for="rating-{{$item->id}}"
                                                                    class="text-sm font-medium text-gray-700">Rating:</label>
                                                                <select name="rating" id="rating-{{$item->id}}" required
                                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                                    <option value="5">★★★★★</option>
                                                                    <option value="4">★★★★☆</option>
                                                                    <option value="3">★★★☆☆</option>
                                                                    <option value="2">★★☆☆☆</option>
                                                                    <option value="1">★☆☆☆☆</option>
                                                                </select>
                                                            </div>
                                                            <div class="flex-grow">
                                                                <label for="comment-{{$item->id}}"
                                                                    class="text-sm font-medium text-gray-700">Komentar:</label>
                                                                <textarea name="comment" id="comment-{{$item->id}}" rows="2"
                                                                    class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                                                    placeholder="Bagaimana kualitas hewannya?"></textarea>
                                                            </div>
                                                            <div>
                                                                <x-primary-button class="mt-4">Kirim</x-primary-button>
                                                            </div>
                                                        </div>
                                                        @error('rating') <span class="text-red-500 text-sm">{{$message}}</span>
                                                        @enderror
                                                    </form>
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="bg-green-50">
                                                <td colspan="3" class="px-6 py-4 text-sm text-green-700">
                                                    <p><strong>Anda telah memberikan review:</strong> {{ $item->review->rating }} ★
                                                        - "{{ $item->review->comment }}"</p>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                    {{-- AKHIR BUNGKUS KONDISI --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <a href="{{ route('pembeli.orders.index') }}"
                            class="text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Riwayat Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>