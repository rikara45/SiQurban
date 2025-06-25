<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Kategori - {{ config('app.name', 'Laravel') }}</title>
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

        /* PERUBAHAN: Input disesuaikan untuk tema terang */
        .input-light {
            background-color: #ffffff !important;
            border-color: #d1d5db !important;
            /* border-gray-300 */
            color: #000000 !important;
        }

        .input-light::placeholder {
            color: #6b7280;
            /* text-gray-500 */
        }

        .custom-btn {
            background-color: #93c47d;
            color: #000000;
        }

        .custom-btn:hover {
            background-color: #6aa84f;
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
                    {{ __('Edit Kategori: ') . $category->name }}
                </h2>
            </div>
        </header>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{-- PERUBAHAN: Menggunakan .content-card --}}
                    <div class="content-card overflow-hidden">
                        <div class="p-6 text-black">
                            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div>
                                    {{-- PERUBAHAN: Label menjadi hitam --}}
                                    <x-input-label for="name" :value="__('Nama Kategori')" class="text-black" />
                                    {{-- PERUBAHAN: Input menggunakan .input-light --}}
                                    <x-text-input id="name" class="block mt-1 w-full input-light" type="text"
                                        name="name" :value="old('name', $category->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="description" :value="__('Deskripsi (Opsional)')"
                                        class="text-black" />
                                    <textarea id="description" name="description"
                                        class="block mt-1 w-full rounded-md shadow-sm input-light"
                                        rows="4">{{ old('description', $category->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    {{-- PERUBAHAN: Tautan batal disesuaikan --}}
                                    <a href="{{ route('admin.categories.index') }}"
                                        class="text-sm text-gray-600 hover:text-black mr-4">
                                        Batal
                                    </a>
                                    {{-- PERUBAHAN: Tombol utama menggunakan .custom-btn --}}
                                    <x-primary-button class="custom-btn">
                                        {{ __('Simpan Perubahan') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>