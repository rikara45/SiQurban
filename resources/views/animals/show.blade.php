<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $animal->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <img src="{{ $animal->photos->first() ? asset('storage/' . $animal->photos->first()->path) : 'https://via.placeholder.com/600' }}" alt="{{ $animal->name }}" class="w-full h-auto object-cover rounded-lg">
                    </div>
                    <div>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $animal->category->name }}</span>
                        <h1 class="text-3xl font-bold mb-2">{{ $animal->name }}</h1>
                        <p class="text-2xl font-bold text-green-600 mb-4">Rp {{ number_format($animal->price, 0, ',', '.') }}</p>

                        {{-- BLOK RATING BARU --}}
                        <div class="flex items-center mb-4">
                            @if($animal->reviews->isNotEmpty())
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($animal->averageRating()) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <span class="text-gray-600 ml-2 text-sm">({{ $animal->average_rating }} dari {{ $animal->reviews->count() }} ulasan)</span>
                            @else
                                <span class="text-gray-500 text-sm">Belum ada ulasan</span>
                            @endif
                        </div>
                        {{-- AKHIR BLOK RATING --}}

                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div><strong>Penjual:</strong> {{ $animal->user->name }}</div>
                            <div><strong>Status:</strong> <span class="font-semibold {{ $animal->status == 'available' ? 'text-green-500' : 'text-red-500' }}">{{ ucfirst($animal->status) }}</span></div>
                            <div><strong>Berat:</strong> {{ $animal->weight }} kg</div>
                            <div><strong>Umur:</strong> {{ $animal->age }} bulan</div>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-bold">Deskripsi:</h4>
                            <p class="text-gray-600">{{ $animal->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>

                        {{-- BUNGKUS SEMUA TOMBOL AKSI DENGAN KONDISI INI --}}
                        @if($animal->status == 'available')
                            @hasrole('pembeli')
                                <div class="mt-6">
                                    <form action="{{ route('pembeli.cart.add', $animal) }}" method="POST">
                                        @csrf
                                        <x-primary-button>
                                            Tambah ke Keranjang
                                        </x-primary-button>
                                    </form>
                                </div>

                                <div class="mt-6 border-t pt-6">
                                    <h4 class="font-bold text-lg">Ajukan Penawaran</h4>
                                    <p class="text-sm text-gray-600 mb-2">Harga asli: Rp {{ number_format($animal->price, 0, ',', '.') }}</p>
                                    <form action="{{ route('pembeli.negotiations.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
                                        <div class="flex items-center space-x-2">
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                                </div>
                                                <input type="number" name="offer_price" id="offer_price" class="block w-full rounded-md border-gray-300 pl-8 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="0" required>
                                            </div>
                                            <x-secondary-button type="submit">
                                                Tawar Harga
                                            </x-secondary-button>
                                        </div>
                                        <x-input-error :messages="$errors->get('offer_price')" class="mt-2" />
                                    </form>
                                    @if(session('success'))
                                        <p class="text-sm text-green-600 mt-2">{{ session('success') }}</p>
                                    @endif
                                    @if(session('error'))
                                        <p class="text-sm text-red-600 mt-2">{{ session('error') }}</p>
                                    @endif
                                </div>
                            @endhasrole
                        @endif
                        {{-- AKHIR BUNGKUS KONDISI --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- BLOK DAFTAR REVIEW BARU --}}
@if($animal->reviews->isNotEmpty())
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-2xl font-semibold mb-4">Ulasan Pembeli</h3>
            <div class="space-y-6">
                @foreach($animal->reviews as $review)
                <div class="border-t pt-4">
                    <div class="flex items-center mb-2">
                        <p class="font-bold">{{ $review->user->name }}</p>
                        <span class="text-gray-400 mx-2">•</span>
                        <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <p class="text-gray-700">{{ $review->comment }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
{{-- AKHIR BLOK DAFTAR REVIEW --}}