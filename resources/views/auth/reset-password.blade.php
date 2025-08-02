@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="p-6 sm:p-8">
            {{-- Logo --}}
           <img src="{{ asset('uang.png') }}"
                 alt="Ilustrasi Uang"
                 class="w-36 md:w-3/4 max-h-52 object-contain rounded-lg shadow-lg hover:scale-105 transition duration-300" />
        </div>

            {{-- Judul --}}
            <h2 class="text-center text-2xl font-semibold text-gray-800 mb-2">
                Reset Password
            </h2>
            <p class="text-sm text-gray-600 text-center mb-6">
                Silakan masukkan password baru untuk akun kamu 🔐
            </p>

            {{-- Error --}}
            <x-validation-errors class="mb-4" />

            {{-- Form --}}
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                {{-- Konfirmasi --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium shadow hover:bg-indigo-700 transition">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
