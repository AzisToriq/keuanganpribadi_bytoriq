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
            <h2 class="text-center text-xl font-semibold text-gray-800 mb-2">
                Verifikasi Email
            </h2>

            {{-- Deskripsi --}}
            <p class="text-sm text-gray-600 text-center mb-6">
                Sebelum melanjutkan, silakan verifikasi email kamu melalui link yang kami kirim. <br>
                Kalau belum nerima emailnya, kamu bisa minta ulang 👇
            </p>

            {{-- Status sukses --}}
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm text-green-600 text-center font-medium">
                    Link verifikasi baru telah dikirim ke email kamu! 📬
                </div>
            @endif

            {{-- Tombol --}}
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-button type="submit">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-button>
                </form>

                <a href="{{ route('profile.show') }}" class="text-sm text-indigo-600 hover:underline font-medium">
                    Ubah Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-red-600 hover:underline font-medium">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
