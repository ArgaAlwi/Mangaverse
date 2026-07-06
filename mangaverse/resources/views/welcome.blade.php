@extends('layouts.master')

@section('title', 'Toko Komik Terlengkap')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section py-5" style="background: linear-gradient(135deg, var(--mv-blue) 0%, #2c3e50 100%); color: white;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <span class="badge bg-warning text-dark mb-2 px-3 py-2 rounded-pill">🔥 Diskon Spesial Bulan Ini</span>
                    <h1 class="display-4 fw-bold mb-3">Jelajahi Dunia Imajinasi Tanpa Batas</h1>
                    <p class="lead mb-4">Temukan ribuan koleksi manga, manhwa, dan komik lokal terbaru. Koleksi lengkap dengan harga terbaik hanya di Mangaverse.</p>
                    <a href="#" class="btn btn-light btn-lg rounded-pill px-4 me-2 text-primary fw-bold">Belanja Sekarang</a>
                    <a href="#" class="btn btn-outline-light btn-lg rounded-pill px-4">Lihat Promo</a>
                </div>
                <div class="col-md-6 text-center">
                    <img src="https://dummyimage.com/600x400/ffffff/3498db.png&text=Mangaverse+Hero+Image" alt="Hero Banner" class="img-fluid rounded-4 shadow-lg" style="transform: rotate(2deg); transition: transform 0.3s;" onmouseover="this.style.transform='rotate(0deg) scale(1.02)'" onmouseout="this.style.transform='rotate(2deg)'">
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori Populer --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Kategori Populer</h3>
            </div>
            <div class="row g-3 text-center">
                @php
                    $categories = [
                        ['icon' => 'fa-fist-raised', 'name' => 'Action', 'color' => 'danger'],
                        ['icon' => 'fa-magic', 'name' => 'Fantasy', 'color' => 'primary'],
                        ['icon' => 'fa-heart', 'name' => 'Romance', 'color' => 'danger'],
                        ['icon' => 'fa-volleyball', 'name' => 'Sports', 'color' => 'warning'],
                        ['icon' => 'fa-ghost', 'name' => 'Horror', 'color' => 'dark'],
                        ['icon' => 'fa-laugh-squint', 'name' => 'Comedy', 'color' => 'success'],
                    ];
                @endphp
                @foreach($categories as $cat)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#" class="text-decoration-none">
                        <div class="card border-0 shadow-sm category-card py-3 rounded-4">
                            <div class="card-body">
                                <i class="fa-solid {{ $cat['icon'] }} fs-1 text-{{ $cat['color'] }} mb-2"></i>
                                <h6 class="text-dark fw-bold m-0">{{ $cat['name'] }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Rekomendasi Mangaverse --}}
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Rekomendasi Mangaverse</h3>
                <a href="#" class="text-decoration-none fw-bold" style="color: var(--mv-blue);">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="row g-4">
                @forelse($featuredComics as $comic)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 comic-card">
                        <div class="position-relative">
                            {{-- Link Gambar --}}
                            <a href="{{ route('front.comic.show', $comic->slug) }}">
                                <img src="{{ $comic->cover ? asset('storage/'.$comic->cover) : 'https://dummyimage.com/300x450/e0e0e0/555555.png&text=No+Cover' }}" 
                                     class="card-img-top" 
                                     alt="{{ $comic->title }}" 
                                     style="height: 350px; object-fit: cover;">
                            </a>
                            
                            @if($comic->discount > 0)
                            <div class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 m-2 rounded fw-bold">
                                -{{ number_format($comic->discount, 0) }}%
                            </div>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                @foreach($comic->genres->take(2) as $genre)
                                    <span class="badge bg-secondary text-white" style="font-size: 0.7rem;">{{ $genre->name }}</span>
                                @endforeach
                            </div>
                            
                            {{-- Link Judul --}}
                            <a href="{{ route('front.comic.show', $comic->slug) }}" class="text-decoration-none text-dark">
                                <h5 class="card-title fw-bold text-truncate" title="{{ $comic->title }}">{{ $comic->title }}</h5>
                            </a>
                            
                            <p class="text-muted small mb-2"><i class="fa-solid fa-pen-nib"></i> {{ $comic->author->name }}</p>
                            
                            <div class="mt-auto">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-star text-warning small"></i>
                                    <span class="ms-1 small fw-bold">{{ $comic->rating }}</span>
                                </div>
                                <h5 class="fw-bold mb-0" style="color: var(--mv-blue);">Rp {{ number_format($comic->price, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 p-3 pt-0">
                            <button class="btn btn-outline-primary w-100 rounded-pill"><i class="fa-solid fa-cart-plus"></i> Masukkan Keranjang</button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Belum ada komik yang tersedia.</h5>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <style>
        .category-card { transition: transform 0.2s, box-shadow 0.2s; }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important; }
        .comic-card { transition: 0.3s; }
        .comic-card:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
    </style>
@endsection