<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    @if(empty($cartItems))
                        <div class="text-center py-10">
                            <p class="text-gray-500 dark:text-gray-400">Keranjang Anda kosong.</p>
                            <a href="{{ route('home') }}"
                                class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                                &larr; Mulai Belanja
                            </a>
                        </div>
                    @else
                        <form action="{{ route('pembeli.checkout.store') }}" method="POST">
                            @csrf
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Item di Keranjang</h3>

                            {{-- 1. TABEL ITEM --}}
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mb-6">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Produk</th>
                                        <th
                                            class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Harga</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($cartItems as $id => $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                                {{ $item['name'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">Rp
                                                {{ number_format($item['price'], 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{-- Jika Anda butuh tombol hapus, letakkan di sini --}}
                                                {{-- Contoh: <a href="#" class="text-red-600 hover:text-red-900">Hapus</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- 2. TOTAL HARGA --}}
                            <div class="text-right mb-6">
                                <p class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                    <strong>Total:</strong>
                                    <span class="text-green-600 dark:text-green-400">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </p>
                            </div>

                            {{-- 3. METODE PENGIRIMAN --}}
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pilih Metode
                                    Pengiriman</h3>
                                <div class="space-y-4">

                                    {{-- Opsi 1: Diantar --}}
                                    <div
                                        class="relative flex items-start bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg shadow-sm">
                                        <div class="flex items-center h-5">
                                            <input id="delivery_diantar" name="delivery_method" type="radio" value="diantar"
                                                required
                                                class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 dark:border-gray-600">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="delivery_diantar"
                                                class="font-medium text-gray-800 dark:text-gray-200">Diantar ke Alamat
                                                Saya</label>
                                            <p class="text-gray-500 dark:text-gray-400">Hewan akan diantarkan ke alamat yang
                                                terdaftar di profil Anda. (Biaya pengiriman mungkin berlaku, konfirmasi
                                                dengan penjual).</p>
                                        </div>
                                    </div>

                                    {{-- Opsi 2: Diambil --}}
                                    <div
                                        class="relative flex items-start bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg shadow-sm">
                                        <div class="flex items-center h-5">
                                            <input id="delivery_diambil" name="delivery_method" type="radio" value="diambil"
                                                class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 dark:border-gray-600">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="delivery_diambil"
                                                class="font-medium text-gray-800 dark:text-gray-200">Saya Ambil
                                                Sendiri</label>
                                            <p class="text-gray-500 dark:text-gray-400">Anda akan mengambil hewan langsung
                                                di lokasi penjual. Alamat penjual akan diinformasikan setelah pesanan
                                                dikonfirmasi.</p>
                                        </div>
                                    </div>

                                    {{-- Opsi 3: Disalurkan (Qurban) --}}
                                    <div
                                        class="relative flex items-start bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg shadow-sm">
                                        <div class="flex items-center h-5">
                                            <input id="delivery_disalurkan" name="delivery_method" type="radio"
                                                value="disalurkan"
                                                class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 dark:border-gray-600">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="delivery_disalurkan"
                                                class="font-medium text-gray-800 dark:text-gray-200">Disalurkan sebagai
                                                Qurban</label>
                                            <p class="text-gray-500 dark:text-gray-400">Anda mewakilkan penyembelihan dan
                                                distribusi daging qurban kepada penjual atau lembaga yang bekerja sama.</p>
                                        </div>
                                    </div>

                                </div>
                                <x-input-error :messages="$errors->get('delivery_method')" class="mt-2" />
                            </div>

                            {{-- 4. TOMBOL SUBMIT --}}
                            <div class="text-right mt-8">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    onclick="return confirm('Konfirmasi pesanan dengan metode pengiriman yang dipilih?');">
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