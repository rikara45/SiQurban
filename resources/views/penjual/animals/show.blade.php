<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Hewan: ') . $animal->name }}
            </h2>
            <a href="{{ route('penjual.animals.edit', $animal) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                {{ __('Edit Hewan') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Animal Photos --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Foto Hewan</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @forelse ($animal->photos as $photo)
                                <div>
                                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Foto {{ $animal->name }}" class="rounded-lg object-cover w-full h-48">
                                </div>
                            @empty
                                <p class="text-gray-500">Tidak ada foto.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Animal Details --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Hewan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $animal->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $animal->category->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Harga</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">Rp {{ number_format($animal->price, 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $animal->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($animal->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Berat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $animal->weight }} kg</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Umur</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $animal->age }} bulan</dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {!! nl2br(e($animal->description ?? 'Tidak ada deskripsi.')) !!}
                                </dd>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <a href="{{ route('penjual.animals.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Daftar Hewan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
