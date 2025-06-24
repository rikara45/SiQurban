<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Pengguna - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .glass { backdrop-filter: blur(16px); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); }
        .input-glass { background: rgba(255, 255, 255, 0.15) !important; border-color: rgba(255, 255, 255, 0.3) !important; color: white !important; }
        .input-glass::placeholder { color: rgba(255, 255, 255, 0.6); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen gradient-bg">
        @include('layouts.navigation')
        <header>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-2xl text-white leading-tight">
                    {{ __('Manajemen Pengguna') }}
                </h2>
            </div>
        </header>
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="glass overflow-hidden shadow-lg rounded-2xl">
                        <div class="p-6 text-white">
                            @if(session('success'))
                                <div class="bg-green-500 bg-opacity-30 border border-green-400 text-white px-4 py-3 rounded relative mb-4" role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="bg-red-500 bg-opacity-30 border border-red-400 text-white px-4 py-3 rounded relative mb-4" role="alert">
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                </div>
                            @endif
                            <div class="mb-4">
                                <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <input type="text" name="search" placeholder="Cari Nama/Email..." value="{{ request('search') }}" class="input-glass rounded-md shadow-sm">
                                    <select name="role" class="input-glass rounded-md shadow-sm">
                                        <option value="">Semua Role</option>
                                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="penjual" {{ request('role') == 'penjual' ? 'selected' : '' }}>Penjual</option>
                                        <option value="pembeli" {{ request('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                                    </select>
                                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-white bg-opacity-20 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30">Cari</button>
                                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-500 bg-opacity-20 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30">Reset</a>
                                </form>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 divide-opacity-20">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 divide-opacity-20">
                                        @forelse ($users as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-white bg-opacity-20">
                                                            {{ ucfirst($role) }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status == 'active' ? 'bg-green-500 bg-opacity-50 text-green-200' : 'bg-red-500 bg-opacity-50 text-red-200' }}">
                                                        {{ ucfirst($user->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if(!$user->hasRole('admin'))
                                                    <form action="{{ route('admin.users.updateStatus', $user) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        @if($user->status == 'active')
                                                            <input type="hidden" name="status" value="suspended">
                                                            <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Anda yakin ingin men-suspend pengguna ini?')">Suspend</button>
                                                        @else
                                                            <input type="hidden" name="status" value="active">
                                                            <button type="submit" class="text-green-400 hover:text-green-300" onclick="return confirm('Anda yakin ingin mengaktifkan pengguna ini?')">Activate</button>
                                                        @endif
                                                    </form>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-400">
                                                    Tidak ada data pengguna.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-white">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>