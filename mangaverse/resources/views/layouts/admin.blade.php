<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Mangaverse Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --mv-blue: #0d6efd;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            color: white;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 20px;
            border-radius: 0;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
        }
        /* Memastikan semua ikon di sidebar punya lebar yang sama agar teksnya rata */
        .sidebar .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: white;
            color: var(--sidebar-bg);
            border-left: 4px solid var(--mv-blue);
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
            width: calc(100% - 250px);
        }
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        /* Mode cetak agar sidebar hilang saat di-print */
        @media print {
            .sidebar { display: none !important; }
            .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
            .navbar { display: none !important; }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar d-print-none">
        <div class="text-center py-4 border-bottom border-secondary">
            <h4 class="fw-bold mb-0 text-white"><i class="fa-solid fa-book-open me-2" style="width: auto;"></i>MANGAVERSE</h4>
            <small class="text-white-50">Admin Panel</small>
        </div>
        
        <div class="nav flex-column mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
            
            <div class="px-3 mt-4 mb-2">
                <small class="text-white-50 fw-bold text-uppercase" style="font-size: 0.75rem;">Manajemen Katalog</small>
            </div>

            <a href="{{ route('admin.comics.index') }}" class="nav-link {{ request()->routeIs('admin.comics.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book"></i> Data Komik
            </a>
            <a href="{{ route('admin.authors.index') }}" class="nav-link {{ request()->routeIs('admin.authors.index') ? 'active' : '' }}">
                <i class="fa-solid fa-pen-nib"></i> Pengarang & Penerbit
            </a>
            <a href="{{ route('admin.stock.index') }}" class="nav-link {{ request()->routeIs('admin.stock.index') ? 'active' : '' }}">
                <i class="fa-solid fa-boxes-stacked"></i> Manajemen Stok
            </a>

            <div class="px-3 mt-4 mb-2">
                <small class="text-white-50 fw-bold text-uppercase" style="font-size: 0.75rem;">Transaksi & Laporan</small>
            </div>

            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show') ? 'active' : '' }}">
                <i class="fa-solid fa-cart-shopping"></i> Pesanan 
                @php
                    $newOrders = \App\Models\Order::where('order_status', 'Pending')->count();
                @endphp
                @if($newOrders > 0)
                    <span class="badge bg-danger ms-auto rounded-pill">{{ $newOrders }} Baru</span>
                @endif
            </a>

            <a href="{{ route('admin.orders.report') }}" class="nav-link {{ request()->routeIs('admin.orders.report') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> Laporan Penjualan
            </a>

            <div class="px-3 mt-4 mb-2">
                <small class="text-white-50 fw-bold text-uppercase" style="font-size: 0.75rem;">Pengembangan Lanjut</small>
            </div>

            <a href="#" onclick="alert('Fitur Data Customer saat ini sedang dalam tahap pengembangan!'); return false;" class="nav-link text-white-50">
                <i class="fa-solid fa-users"></i> Data Customer
            </a>
            <a href="#" onclick="alert('Fitur Promo & Voucher saat ini sedang dalam tahap pengembangan!'); return false;" class="nav-link text-white-50">
                <i class="fa-solid fa-ticket"></i> Promo & Voucher
            </a>
        </div>
    </div>

    <div class="main-content bg-light">
        <nav class="navbar navbar-expand-lg bg-white rounded-4 shadow-sm mb-4 px-4 py-3 d-print-none">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 fw-bold text-muted fs-5">@yield('title')</span>
                
                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <a class="text-decoration-none text-dark dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0d6efd&color=fff" class="rounded-circle me-2" width="35" height="35" alt="Admin">
                            <span class="fw-bold small">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2">
                            <li><a class="dropdown-item" href="{{ route('home') }}"><i class="fa-solid fa-house me-2"></i> Ke Halaman Toko</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-bold"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>