<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Hewan Kurban Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Menampilkan error validasi umum --}}
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('penjual.animals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Hewan')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Sapi Limosin Super" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                             <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Harga (Rp)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required placeholder="Contoh: 25000000"/>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Weight -->
                        <div class="mt-4">
                            <x-input-label for="weight" :value="__('Berat (kg)')" />
                            <x-text-input id="weight" class="block mt-1 w-full" type="number" step="0.1" name="weight" :value="old('weight')" required placeholder="Contoh: 350.5" />
                             <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                        </div>

                        <!-- Age -->
                        <div class="mt-4">
                            <x-input-label for="age" :value="__('Umur (bulan)')" />
                            <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')" required placeholder="Contoh: 24" />
                             <x-input-error :messages="$errors->get('age')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" placeholder="Jelaskan kondisi hewan, riwayat kesehatan, dll.">{{ old('description') }}</textarea>
                             <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Photos -->
                        <div class="mt-4">
                            <x-input-label for="photos" :value="__('Foto Hewan (Maksimal 3 foto)')" />
                            <input id="photos" type="file" name="photos[]" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                            <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                            <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-6">
                             <a href="{{ route('penjual.animals.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Hewan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
