<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(empty($cartItems))
                        <div class="text-center py-10">
                            <p class="text-gray-500">Keranjang Anda kosong.</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-900">
                                &larr; Mulai Belanja
                            </a>
                        </div>
                    @else
                        <form action="{{ route('pembeli.checkout.store') }}" method="POST">
                            @csrf
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Item di Keranjang</h3>
                            <table class="min-w-full divide-y divide-gray-200 mb-6">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                        <th class="px-6 py-3 bg-gray-50"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cartItems as $id => $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap">{{ $item['name'] }}</td>
                                            <td class="px-6 py-4 whitespace-no-wrap">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm font-medium">
                                                {{-- Form untuk hapus item --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="text-right mb-6">
                                <p class="text-lg"><strong>Total:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
                            </div>

                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Pilih Metode Pengiriman</h3>
                                <div class="space-y-4">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="delivery_diantar" name="delivery_method" type="radio" value="diantar" required class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="delivery_diantar" class="font-medium text-gray-700">Diantar ke Alamat Saya</label>
                                            <p class="text-gray-500">Hewan akan diantarkan ke alamat yang terdaftar di profil Anda. (Biaya pengiriman mungkin berlaku, konfirmasi dengan penjual).</p>
                                        </div>
                                    </div>
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="delivery_diambil" name="delivery_method" type="radio" value="diambil" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="delivery_diambil" class="font-medium text-gray-700">Saya Ambil Sendiri</label>
                                            <p class="text-gray-500">Anda akan mengambil hewan langsung di lokasi penjual. Alamat penjual akan diinformasikan setelah pesanan dikonfirmasi.</p>
                                        </div>
                                    </div>
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="delivery_disalurkan" name="delivery_method" type="radio" value="disalurkan" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="delivery_disalurkan" class="font-medium text-gray-700">Disalurkan sebagai Qurban</label>
                                            <p class="text-gray-500">Anda mewakilkan penyembelihan dan distribusi daging qurban kepada penjual atau lembaga yang bekerja sama.</p>
                                        </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('delivery_method')" class="mt-2" />
                            </div>

                            <div class="text-right mt-6">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500" onclick="return confirm('Konfirmasi pesanan dengan metode pengiriman yang dipilih?');">
                                    Buat Pesanan & Bayar
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>