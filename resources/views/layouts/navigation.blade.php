<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo diganti dengan teks -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <span class="text-2xl font-bold text-purple-700 dark:text-white">SiQurban</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @hasrole('admin')
                            {{-- Link Beranda untuk Admin --}}
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                {{ __('Beranda') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>
                        @endhasrole

                        @hasrole('penjual')
                            {{-- Link Beranda untuk Penjual --}}
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                {{ __('Beranda') }}
                            </x-nav-link>
                            <x-nav-link :href="route('penjual.dashboard')" :active="request()->routeIs('penjual.dashboard')">
                                {{ __('Penjual Dashboard') }}
                            </x-nav-link>
                             <x-nav-link :href="route('penjual.animals.index')" :active="request()->routeIs('penjual.animals.*')">
                                {{ __('Hewan Saya') }}
                            </x-nav-link>
                            <x-nav-link :href="route('penjual.orders.index')" :active="request()->routeIs('penjual.orders.*')">
                                {{ __('Manajemen Pesanan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('penjual.negotiations.index')" :active="request()->routeIs('penjual.negotiations.*')">
                                {{ __('Negosiasi') }}
                            </x-nav-link>
                        @endhasrole

                        @hasrole('pembeli')
                            {{-- Teks diubah menjadi Beranda --}}
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                {{ __('Beranda') }}
                            </x-nav-link>
                             <x-nav-link :href="route('pembeli.cart.index')" :active="request()->routeIs('pembeli.cart.*')">
                                {{ __('Keranjang') }}
                            </x-nav-link>
                             <x-nav-link :href="route('pembeli.orders.index')" :active="request()->routeIs('pembeli.orders.*')">
                                {{ __('Riwayat Pesanan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('pembeli.negotiations.index')" :active="request()->routeIs('pembeli.negotiations.*')">
                                {{ __('Negosiasi Saya') }}
                            </x-nav-link>
                        @endhasrole
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Tombol Login dan Daftar yang Diperbaiki --}}
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
             @auth
                @hasrole('admin')
                    <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Beranda') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                @endhasrole
                @hasrole('penjual')
                     <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Beranda') }}
                    </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('penjual.dashboard')" :active="request()->routeIs('penjual.dashboard')">
                        {{ __('Penjual Dashboard') }}
                    </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('penjual.animals.index')" :active="request()->routeIs('penjual.animals.*')">
                        {{ __('Hewan Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('penjual.orders.index')" :active="request()->routeIs('penjual.orders.*')">
                        {{ __('Manajemen Pesanan') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('penjual.negotiations.index')" :active="request()->routeIs('penjual.negotiations.*')">
                        {{ __('Negosiasi') }}
                    </x-responsive-nav-link>
                @endhasrole
                 @hasrole('pembeli')
                    <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Beranda') }}
                    </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('pembeli.cart.index')" :active="request()->routeIs('pembeli.cart.*')">
                        {{ __('Keranjang') }}
                    </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('pembeli.orders.index')" :active="request()->routeIs('pembeli.orders.*')">
                        {{ __('Riwayat Pesanan') }}
                    </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('pembeli.negotiations.index')" :active="request()->routeIs('pembeli.negotiations.*')">
                        {{ __('Negosiasi Saya') }}
                    </x-responsive-nav-link>
                @endhasrole
             @else
                 {{-- Tombol Mobile Login dan Daftar yang Diperbaiki --}}
                 <div class="px-4 py-3 space-y-2">
                     <a href="{{ route('login') }}" 
                        class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                         </svg>
                         Masuk
                     </a>
                     <a href="{{ route('register') }}" 
                        class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                         </svg>
                         Daftar
                     </a>
                 </div>
             @endauth
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>