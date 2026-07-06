<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mangaverse - Toko Komik Online')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --mv-blue: #0d6efd;
            --mv-blue-hover: #0b5ed7;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Nunito', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-brand { letter-spacing: 1px; }
        .dropdown-item:hover { background-color: #f1f5f9; }
        main { flex: 1; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                <i class="fa-solid fa-book-open me-2"></i>MANGAVERSE
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link fw-bold {{ request()->routeIs('home') ? 'text-primary' : 'text-dark' }}" href="{{ route('home') }}">Katalog Komik</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav align-items-center">
                    @auth
                        <li class="nav-item me-4 mt-2 mt-lg-0">
                            <a class="nav-link position-relative text-dark" href="{{ route('cart.index') }}">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                                @php
                                    // Menghitung jumlah item di keranjang user yang sedang login
                                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                                @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm" style="font-size: 0.65rem;">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown mt-2 mt-lg-0">
                            <a class="nav-link dropdown-toggle fw-bold text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0d6efd&color=fff" class="rounded-circle me-2" width="30" height="30" alt="Avatar">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-3 rounded-3">
                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
                                    <li><a class="dropdown-item fw-bold text-primary py-2" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-2"></i>Panel Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                
                                <li><a class="dropdown-item py-2" href="{{ route('customer.orders') }}"><i class="fa-solid fa-bag-shopping me-2 text-muted"></i>Pesanan Saya</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fa-solid fa-gear me-2 text-muted"></i>Pengaturan Akun</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold py-2"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item me-2"><a class="nav-link fw-bold text-dark" href="{{ route('login') }}">Masuk</a></li>
                        <li class="nav-item"><a class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" href="{{ route('register') }}" style="background-color: var(--mv-blue); border:none;">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center text-muted">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-book-open me-2 text-primary"></i>MANGAVERSE</h5>
            <p class="mb-1 small">Sistem Informasi Penjualan Komik Online Berbasis Laravel.</p>
            <p class="mb-0 fw-bold small">&copy; {{ date('Y') }} Mangaverse Bookstore. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>