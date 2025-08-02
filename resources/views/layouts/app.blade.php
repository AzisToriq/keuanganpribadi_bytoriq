<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Keuangan Pribadi') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Styles & Scripts --}}
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>
@livewireStyles

</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col">

        {{-- ✅ Navbar --}}
        <nav class="bg-white shadow border-b" x-data="{ navOpen: false, profileOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                
                {{-- Left Side --}}
                <div class="flex items-center gap-8">
                    <div class="text-xl font-bold text-indigo-600">Keuangan Pribadi</div>

                    @auth
                    <div class="hidden md:flex items-center gap-4 text-sm font-medium text-gray-700">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">📊 Dashboard</a>
                        <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.index') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">🗂️ Transaksi</a>
                        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.index') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">📂 Kategori</a>
                    </div>
                    @endauth
                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-4">
                    {{-- Burger Menu --}}
                    <div class="md:hidden">
                        <button @click="navOpen = !navOpen" class="text-gray-700 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!navOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="navOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Profile Dropdown --}}
                    @auth
                    <div class="hidden md:flex items-center gap-2 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ $profilePhoto }}" class="h-8 w-8 rounded-full object-cover" alt="Foto Profil">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition
                             class="absolute top-full right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border z-50 py-2 text-sm space-y-1">
                            <div class="px-4 py-2 text-gray-700 leading-tight">
                                👋 Hai, <strong class="block truncate text-indigo-600">{{ Auth::user()->name }}</strong>
                            </div>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">👤 Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            {{-- Mobile Menu --}}
            @auth
            <div x-show="navOpen" x-transition class="md:hidden px-4 pt-4 pb-2 bg-white shadow-sm border-t text-sm space-y-2">
                <a href="{{ route('dashboard') }}" class="block py-1 {{ request()->routeIs('dashboard') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">📊 Dashboard</a>
                <a href="{{ route('transactions.index') }}" class="block py-1 {{ request()->routeIs('transactions.index') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">🗂️ Transaksi</a>
                <a href="{{ route('categories.index') }}" class="block py-1 {{ request()->routeIs('categories.index') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">📂 Kategori</a>

                <hr class="my-2">
                <div class="flex items-center gap-3 py-3 border-b">
                    <img src="{{ $profilePhoto }}" class="h-10 w-10 rounded-full object-cover" alt="Foto Profil">
                    <div class="text-sm leading-tight">
                        👋 Hai, <strong class="block text-indigo-600">{{ Auth::user()->name }}</strong>
                    </div>
                </div>
                <a href="{{ route('profile.show') }}" class="block py-1 hover:text-indigo-600">👤 Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-1 hover:text-indigo-600">🚪 Logout</button>
                </form>
            </div>
            @endauth
        </nav>

        {{-- ✅ Main Content --}}
        <main class="flex-1 p-4 sm:p-6 bg-gray-50">
            <div class="max-w-7xl mx-auto space-y-6">

{{-- ✅ Welcome Section --}}
@auth
<div class="flex flex-col items-center justify-center text-center space-y-6 py-8 px-4">
    <img src="{{ asset('uang.png') }}"
         alt="Ilustrasi Uang"
         class="w-40 md:w-1/2 max-h-60 object-contain rounded-xl shadow-xl hover:scale-105 transition-transform duration-300 ease-in-out" />

    <div class="bg-gradient-to-br from-indigo-100 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
                border border-indigo-200 dark:border-gray-700 rounded-2xl shadow-lg backdrop-blur-sm px-6 py-6 max-w-xl w-full transition duration-300">
        
        <h2 class="text-2xl md:text-3xl font-bold text-indigo-800 dark:text-white tracking-wide">
            Selamat Datang, <span class="text-indigo-600 dark:text-indigo-300">{{ Auth::user()->name }}</span>
        </h2>
        <p class="text-sm md:text-base text-gray-700 dark:text-gray-300 mt-2">
            Pantau dan atur keuanganmu dengan mudah, aman, dan rapi ✨
        </p>
    </div>
</div>
@endauth
                {{-- Halaman Konten --}}
                @yield('content')

                <div class="text-center text-xs text-gray-500 pt-6 border-t">
                    Aplikasi <span class="font-semibold text-indigo-600">Keuangan Pribadi</span> — Dibuat oleh <strong>Toriq</strong>
                </div>
            </div>
        </main>
    </div>

    {{-- Scripts --}}
    @livewireScripts
    @stack('modals')
    @stack('scripts')
    <script src="https://unpkg.com/alpinejs" defer></script>
</body>
</html>
