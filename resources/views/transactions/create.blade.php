@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        📝 Tambah Transaksi Baru
    </h2>
@endsection

@section('content')
<div class="py-12 bg-[#f9fbff] min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-xl p-8 space-y-8 border border-gray-100">

            {{-- Error Validation --}}
            @if ($errors->any())
                <div class="p-4 bg-red-100 text-red-700 rounded-md border border-red-200 shadow-sm">
                    <strong class="font-semibold">Ups! Ada kesalahan input:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Judul --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Transaksi</label>
                    <input type="text" name="title" id="title" placeholder="Contoh: Gaji, Jajan, Beli Buku"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        value="{{ old('title') }}">
                    @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" step="0.01" name="amount" id="amount" placeholder="Contoh: 50000"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        value="{{ old('amount') }}">
                    @error('amount') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tipe --}}
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Transaksi</label>
                    <select name="type" id="type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date" id="date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        value="{{ old('date') }}">
                    @error('date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Upload Bukti --}}
                <div>
                    <label for="receipt" class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti (Opsional)</label>
                    <input type="file" name="receipt" id="receipt" accept=".jpg,.jpeg,.png,.pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                    @error('receipt') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('transactions.index') }}"
                        class="text-sm text-gray-500 hover:underline hover:text-indigo-600 transition">
                        ← Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition duration-200">
                        💾 Simpan Transaksi
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
