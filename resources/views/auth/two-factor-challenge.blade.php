@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="p-6 sm:p-8" x-data="{ recovery: false }">
            {{-- Logo --}}
            <img src="{{ asset('uang.png') }}"
                 alt="Ilustrasi Uang"
                 class="w-36 md:w-3/4 max-h-52 object-contain rounded-lg shadow-lg hover:scale-105 transition duration-300" />
        </div>

            {{-- Judul --}}
            <h2 class="text-center text-2xl font-semibold text-gray-800 mb-2">
                Two-Factor Authentication
            </h2>

            {{-- Deskripsi --}}
            <p class="text-sm text-gray-600 text-center mb-6" x-show="!recovery">
                Masukkan kode autentikasi dari aplikasi autentikator kamu 📱
            </p>
            <p class="text-sm text-gray-600 text-center mb-6" x-cloak x-show="recovery">
                Atau masukkan kode pemulihan darurat jika kamu kehilangan akses autentikator 🧯
            </p>

            {{-- Error --}}
            <x-validation-errors class="mb-4" />

            {{-- Form --}}
            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                {{-- Authenticator Code --}}
                <div class="mb-4" x-show="! recovery">
                    <label for="code" class="block text-sm font-medium text-gray-700">Kode Autentikasi</label>
                    <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" x-ref="code"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                {{-- Recovery Code --}}
                <div class="mb-4" x-cloak x-show="recovery">
                    <label for="recovery_code" class="block text-sm font-medium text-gray-700">Kode Pemulihan</label>
                    <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code" x-ref="recovery_code"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                {{-- Aksi --}}
                <div class="flex items-center justify-between mt-6">
                    <button type="button"
                        class="text-sm text-gray-600 hover:text-indigo-600 transition font-medium underline"
                        x-show="! recovery"
                        x-on:click="
                            recovery = true;
                            $nextTick(() => { $refs.recovery_code.focus() });
                        ">
                        Gunakan kode pemulihan
                    </button>

                    <button type="button"
                        class="text-sm text-gray-600 hover:text-indigo-600 transition font-medium underline"
                        x-cloak
                        x-show="recovery"
                        x-on:click="
                            recovery = false;
                            $nextTick(() => { $refs.code.focus() });
                        ">
                        Gunakan kode autentikasi
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium shadow hover:bg-indigo-700 transition ms-4">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
