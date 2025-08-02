@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-3xl bg-white shadow-xl rounded-2xl overflow-hidden flex flex-col md:flex-row">

        {{-- Gambar (Atas di Mobile, Kiri di Desktop) --}}
        <div class="bg-gradient-to-br from-lime-400 via-emerald-400 to-teal-500 flex flex-col items-center justify-center p-6 md:w-1/2 order-0 md:order-none">
            <h2 class="text-2xl md:text-3xl font-bold text-white drop-shadow text-center">Selamat Datang!</h2>
            <p class="text-sm text-white text-center mt-2 mb-4">Kelola keuanganmu dengan lebih cerdas 💸</p>
            <img src="{{ asset('uang.png') }}"
                 alt="Ilustrasi Uang"
                 class="w-36 md:w-3/4 max-h-52 object-contain rounded-lg shadow-lg hover:scale-105 transition duration-300" />
        </div>

        {{-- Form Login --}}
        <div class="p-6 sm:p-10 w-full md:w-1/2 order-1 md:order-1">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 text-center mb-6">Masuk ke Akun</h2>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 p-3 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 p-3 rounded-md">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Lupa password?</a>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Belum punya akun?</a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md font-semibold text-sm shadow-md hover:bg-indigo-700 transition">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
