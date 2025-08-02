@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Riwayat Transaksi') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg p-6">

            {{-- Filter & Search --}}
            <form action="{{ route('transactions.index') }}" method="GET" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="keyword" class="block text-sm font-medium text-gray-700">Cari Judul</label>
                        <input type="text" name="keyword" id="keyword" placeholder="cth: Gaji bulanan" value="{{ request('keyword') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipe</label>
                        <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700">Bulan</label>
                        <input type="month" name="month" id="month" value="{{ request('month') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                        Filter
                    </button>
                    <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-semibold rounded-md hover:bg-gray-400">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Aksi --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-3">
                <a href="{{ route('transactions.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md font-semibold text-sm hover:bg-green-700">
                    Tambah Transaksi
                </a>
                <form action="{{ route('transactions.export.pdf') }}" method="GET">
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                    <input type="hidden" name="type" value="{{ request('type') }}">
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    <input type="hidden" name="month" value="{{ request('month') }}">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md font-semibold text-sm hover:bg-red-700">
                        Export ke PDF
                    </button>
                </form>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md font-semibold text-sm hover:bg-gray-700">
                    Kembali ke Dashboard
                </a>
            </div>

            {{-- Pesan --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $transaction->date->isoFormat('D MMM YYYY') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                    {{ $transaction->title }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $transaction->category->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if ($transaction->receipt)
                                        @php
                                            $ext = pathinfo($transaction->receipt, PATHINFO_EXTENSION);
                                        @endphp

                                        @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                            <a href="{{ asset('storage/' . $transaction->receipt) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $transaction->receipt) }}" class="w-12 h-12 object-cover rounded-md" alt="Bukti">
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $transaction->receipt) }}" target="_blank" class="text-indigo-600 hover:underline">
                                                Lihat File
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-bold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type == 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm space-x-3">
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data transaksi ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
