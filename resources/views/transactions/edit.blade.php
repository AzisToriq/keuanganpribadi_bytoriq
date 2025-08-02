@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Transaksi') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

            {{-- Error Validation --}}
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">{{ __('Whoops! Ada kesalahan input.') }}</div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Edit Transaction Form --}}
            <form action="{{ route('transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Judul Transaksi --}}
                <div>
                    <label for="title" class="block font-medium text-sm text-gray-700">Judul Transaksi</label>
                    <input type="text" name="title" id="title"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300"
                        value="{{ old('title', $transaction->title) }}">
                    @error('title') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Nominal --}}
                <div>
                    <label for="amount" class="block font-medium text-sm text-gray-700">Jumlah</label>
                    <input type="number" name="amount" id="amount" step="0.01"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300"
                        value="{{ old('amount', $transaction->amount) }}">
                    @error('amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Tipe Transaksi --}}
                <div>
                    <label for="type" class="block font-medium text-sm text-gray-700">Tipe</label>
                    <select name="type" id="type"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                        <option value="income" {{ old('type', $transaction->type) === 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ old('type', $transaction->type) === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('type') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="date" class="block font-medium text-sm text-gray-700">Tanggal</label>
                    <input type="date" name="date" id="date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300"
                        value="{{ old('date', $transaction->date->format('Y-m-d')) }}">
                    @error('date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Upload Bukti --}}
                <div>
                    <label for="receipt" class="block font-medium text-sm text-gray-700">Upload Bukti (Opsional)</label>
                    <input type="file" name="receipt" id="receipt" accept=".jpg,.jpeg,.png,.pdf"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                    @error('receipt') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

                    @if ($transaction->receipt)
                        <p class="text-sm mt-2 text-gray-500">Bukti saat ini:
                            <a href="{{ asset('storage/' . $transaction->receipt) }}" target="_blank" class="underline text-indigo-600 hover:text-indigo-800 transition">
                                Lihat File
                            </a>
                        </p>
                    @endif
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('transactions.index') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 mr-4 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
