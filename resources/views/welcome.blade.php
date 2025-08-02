<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keuangan Pribadi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fbff;
            color: #2c3e50;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .hero-section {
            padding: 80px 0;
            background: linear-gradient(120deg, #e0f7fa, #e3fcec);
        }

        .hero-img {
            max-width: 100%;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .btn-main {
            background-color: #00b894;
            color: white;
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .btn-main:hover {
            background-color: #008e74;
            color: #fff;
        }

        .card-highlight {
            background: linear-gradient(to right, #d1f7ff, #f0fff4);
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        footer {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand text-success" href="#">💼 Keuangan Pribadi</a>
            <div class="d-flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-success">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success me-2">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Text -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <h1 class="display-5 fw-bold mb-3">Kontrol Uangmu. Atur Masa Depanmu.</h1>
                    <p class="lead mb-4">Pantau pemasukan dan pengeluaran dengan mudah. Bikin keputusan keuangan yang lebih bijak. Mulai dari sekarang!</p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-main">Buka Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-main me-2">Daftar Gratis</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-dark">Login</a>
                    @endauth
                </div>
                <!-- Image -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('uang.png') }}" class="hero-img" alt="Finance Illustration" style="max-width: 50%; height: auto;">
                </div>

    </section>

    <!-- Highlight Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 card-highlight h-100">
                        <h5 class="fw-bold mb-2">🔍 Transparan & Jelas</h5>
                        <p>Lihat alur uangmu secara real-time dengan grafik dan histori transaksi yang rapi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 card-highlight h-100">
                        <h5 class="fw-bold mb-2">📊 Laporan Keuangan</h5>
                        <p>Export ke PDF dan pantau pengeluaran bulanan. Cocok buat budgeting mingguan juga.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 card-highlight h-100">
                        <h5 class="fw-bold mb-2">🔐 Aman & Pribadi</h5>
                        <p>Akunmu terlindungi, dan data tidak dibagikan ke pihak ketiga. Fully private & secure.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4 text-muted small">
        &copy; {{ date('Y') }} Aplikasi Keuangan Pribadi— Dibuat oleh Toriq
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
