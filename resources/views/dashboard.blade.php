@extends('layouts.app')

@section('header')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Selamat Datang, {{ Auth::user()->name }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">Berikut adalah ringkasan keuangan Anda.</p>
    </div>

    <a href="{{ route('transactions.create') }}"
        class="mt-2 px-5 py-2.5 bg-black text-white rounded-md text-sm font-semibold shadow hover:bg-gray-800 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
        + Tambah Transaksi
    </a>
</div>
@endsection

@section('content')
<div class="py-12 space-y-16 bg-[#f9fbff] min-h-screen">

    {{-- Ringkasan --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
            <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Saldo Akhir</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">Sisa dana yang tersedia</p>
            </div>

            <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-green-500">
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Pemasukan</h3>
                <p class="mt-2 text-3xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">Akumulasi pendapatan</p>
            </div>

            <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-red-500">
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Pengeluaran</h3>
                <p class="mt-2 text-3xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">Akumulasi biaya</p>
            </div>

            <a href="{{ route('categories.index') }}"
                class="block bg-white shadow-md rounded-xl p-6 border-l-4 border-purple-500 hover:bg-gray-50 transition">
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Kelola Kategori</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $categories->count() }} Kategori</p>
                <p class="text-xs text-gray-500 mt-1">Atur kategori transaksi Anda</p>
            </a>
        </div>
    </div>
{{-- Aksi Cepat --}}
<div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
    {{-- Gambar + Teks --}}
    <div class="flex items-center gap-4 md:w-1/2">
        <img src="{{ asset('uang.png') }}" alt="Finance Illustration"
            class="w-20 h-auto">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Atur Transaksi Mu!</h2>
            <p class="text-sm text-gray-600">Dengan ini anda tahu detail pemasukan & Pengeluaran</p>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('transactions.create') }}"
            class="inline-flex items-center justify-center px-5 py-2.5 bg-black text-white text-sm font-semibold rounded-md shadow hover:bg-gray-800 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
            + Tambah Transaksi
        </a>
    </div>
</div>

    {{-- Aktivitas Terbaru --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Aktivitas Terbaru</h3>
                <a href="{{ route('transactions.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-500">Lihat Semua Transaksi</a>
            </div>

            <div class="space-y-4">
                @forelse ($transactions as $transaction)
                <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg border-b border-gray-200">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center {{ $transaction->type == 'income' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        @if ($transaction->type == 'income')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v12m6-6H6" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 12H6" />
                        </svg>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <p class="font-semibold text-gray-800">{{ $transaction->title }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $transaction->category->name ?? 'Tanpa Kategori' }} ·
                            {{ \Carbon\Carbon::parse($transaction->date)->isoFormat('D MMM YYYY') }}
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-semibold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type == 'income' ? '+' : '-' }} Rp
                            {{ number_format($transaction->amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada transaksi</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai catat keuanganmu dengan menekan tombol "Tambah Transaksi".</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Grafik Keuangan Bulanan --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-xl p-6 space-y-8">
            <h3 class="text-lg font-semibold text-gray-800">Grafik Keuangan Bulanan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Bar Chart --}}
                <div>
                    <canvas id="monthlyChart" class="w-full h-full"></canvas>
                </div>

                {{-- Donut Chart --}}
                <div class="text-center">
                    <h4 class="text-sm font-semibold text-gray-600 mb-3">Proporsi Pemasukan vs Pengeluaran Bulan Ini</h4>
                    <canvas id="donutChart" class="w-full max-w-[300px] mx-auto"></canvas>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                    <h4 class="text-sm font-medium text-green-700 uppercase">Pemasukan Bulan Ini</h4>
                    <p class="mt-1 text-2xl font-bold text-green-700">
                        Rp {{ number_format($monthlyStats->last()?->income ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <h4 class="text-sm font-medium text-red-700 uppercase">Pengeluaran Bulan Ini</h4>
                    <p class="mt-1 text-2xl font-bold text-red-700">
                        Rp {{ number_format($monthlyStats->last()?->expense ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
                    <h4 class="text-sm font-medium text-blue-700 uppercase">Selisih Bulan Ini</h4>
                    @php
                        $lastIncome = $monthlyStats->last()?->income ?? 0;
                        $lastExpense = $monthlyStats->last()?->expense ?? 0;
                        $diff = $lastIncome - $lastExpense;
                    @endphp
                    <p class="mt-1 text-2xl font-bold {{ $diff >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                        Rp {{ number_format($diff, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyLabels = @json($monthlyStats->pluck('month'));
    const incomeData = @json($monthlyStats->pluck('income'));
    const expenseData = @json($monthlyStats->pluck('expense'));

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: incomeData,
                    backgroundColor: '#10B981',
                    borderRadius: 6
                },
                {
                    label: 'Pengeluaran',
                    data: expenseData,
                    backgroundColor: '#EF4444',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.dataset.label}: Rp ${ctx.parsed.y.toLocaleString('id-ID')}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // Donut chart
    const lastIncome = {{ $lastIncome }};
    const lastExpense = {{ $lastExpense }};

    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pemasukan', 'Pengeluaran'],
            datasets: [{
                data: [lastIncome, lastExpense],
                backgroundColor: ['#10B981', '#EF4444'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: Rp ${ctx.parsed.toLocaleString('id-ID')}`
                    }
                }
            },
            cutout: '65%'
        }
    });
</script>
@endpush
@endsection
