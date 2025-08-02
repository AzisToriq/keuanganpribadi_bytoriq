<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 22px;
            margin: 0;
            color: #2c3e50;
        }

        .meta {
            font-size: 12px;
            margin-top: 4px;
            color: #555;
        }

        hr {
            margin: 15px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #f8f9fa;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            font-size: 12px;
        }

        th {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .income {
            color: #27ae60;
            font-weight: bold;
        }

        .expense {
            color: #e74c3c;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Laporan Transaksi Keuangan</h1>
    <div class="meta">
        Periode: {{ $month ? \Carbon\Carbon::parse($month)->translatedFormat('F Y') : 'Semua' }}<br>
        Dicetak: {{ $printedAt }}
    </div>
</header>

    <hr>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 30%;">Judul</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 10%;">Tipe</th>
                <th class="text-right" style="width: 20%;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</td>
                    <td>{{ $transaction->title }}</td>
                    <td>{{ $transaction->category->name }}</td>
                    <td class="{{ $transaction->type }}">{{ ucfirst($transaction->type) }}</td>
                    <td class="text-right {{ $transaction->type }}">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="no-data">
                        Tidak ada data transaksi pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
