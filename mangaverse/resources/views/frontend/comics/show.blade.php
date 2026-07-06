@extends('layouts.master')

@section('title', $comic->title . ' - Mangaverse')

@section('content')
<div class="container py-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i><strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error') || $errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i><strong>Gagal!</strong> Pastikan pesananmu benar atau stok mencukupi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <a href="{{ route('home') }}" class="btn btn-outline-secondary mb-4 rounded-pill fw-bold">
        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Katalog
    </a>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="row g-0">
            <div class="col-md-4 p-4 text-center bg-light">
                <img src="{{ $comic->cover ? asset('storage/'.$comic->cover) : 'https://dummyimage.com/300x400' }}" class="img-fluid rounded-4 shadow" alt="{{ $comic->title }}" style="max-height: 450px; object-fit: cover;">
            </div>
            <div class="col-md-8 p-4 p-md-5 d-flex flex-column">
                <div class="mb-auto">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 rounded-pill">Manga</span>
                    <h2 class="fw-bold mb-3">{{ $comic->title }}</h2>
                    
                    <div class="d-flex gap-4 mb-4 text-muted">
                        <div><i class="fa-solid fa-pen-nib me-2"></i>{{ is_object($comic->author) ? $comic->author->name : ($comic->author ?? 'Tanpa Pengarang') }}</div>
                        <div><i class="fa-solid fa-building me-2"></i>{{ is_object($comic->publisher) ? $comic->publisher->name : ($comic->publisher ?? 'Tanpa Penerbit') }}</div>
                    </div>

                    <h3 class="fw-bold mb-4" style="color: var(--mv-blue);">Rp {{ number_format($comic->price, 0, ',', '.') }}</h3>
                    
                    <p class="text-muted lh-lg mb-0">
                        Menyelami dunia fantasi yang menakjubkan dalam edisi terbaru {{ $comic->title }}. Ikuti petualangan seru yang penuh dengan aksi, misteri, dan komedi yang akan membuatmu tidak bisa berhenti membalik halamannya!
                    </p>
                </div>

                <div class="mt-5 pt-4 border-top d-flex align-items-center gap-4">
                    <div>
                        <small class="text-muted d-block mb-1">Status Stok</small>
                        @if($comic->stock > 0)
                            <span class="badge bg-success px-3 fs-6 rounded-pill"><i class="fa-solid fa-check me-1"></i> Tersedia ({{ $comic->stock }})</span>
                        @else
                            <span class="badge bg-danger px-3 fs-6 rounded-pill"><i class="fa-solid fa-xmark me-1"></i> Habis Terjual</span>
                        @endif
                    </div>
                    
                    @if($comic->stock > 0)
                    <form action="{{ route('cart.store', $comic->id) }}" method="POST" class="ms-auto d-flex gap-2 align-items-center">
                        @csrf
                        <input type="number" name="quantity" class="form-control border-2 text-center fw-bold" value="1" min="1" max="{{ $comic->stock }}" style="width: 80px; height: 48px;" required>
                        
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm px-4" style="background-color: var(--mv-blue); border:none; height: 48px;">
                            <i class="fa-solid fa-cart-plus me-2"></i>Tambah
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mt-5">
        <div class="card-header bg-white pt-4 pb-2 px-4 border-bottom-0">
            <h5 class="fw-bold m-0"><i class="fa-solid fa-star text-warning me-2"></i>Ulasan Pembaca</h5>
        </div>
        <div class="card-body p-4">

            <div class="mb-5">
                @forelse($comic->reviews as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-dark">{{ $review->user->name }}</span>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="text-warning mb-2" style="font-size: 0.85rem;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fa-solid fa-star"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted mb-0 small">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-center text-muted my-4">Belum ada ulasan untuk komik ini. Jadilah yang pertama!</p>
                @endforelse
            </div>

            @auth
                <div class="bg-light p-4 rounded-4 border">
                    <h6 class="fw-bold mb-3">Tulis Ulasan Kamu</h6>
                    <form action="{{ route('reviews.store', $comic->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Beri Rating</label>
                            <select name="rating" class="form-select border-2" required>
                                <option value="">-- Pilih Rating Bintang --</option>
                                <option value="5">⭐⭐⭐⭐⭐ (5/5) - Sangat Bagus</option>
                                <option value="4">⭐⭐⭐⭐ (4/5) - Bagus</option>
                                <option value="3">⭐⭐⭐ (3/5) - Lumayan</option>
                                <option value="2">⭐⭐ (2/5) - Kurang</option>
                                <option value="1">⭐ (1/5) - Mengecewakan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Komentar</label>
                            <textarea name="comment" rows="3" class="form-control border-2" placeholder="Tulis pendapatmu tentang komik ini..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4" style="background-color: var(--mv-blue); border:none;">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            @else
                <div class="alert alert-secondary text-center rounded-3 mb-0 border-0">
                    Silakan <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Login</a> terlebih dahulu untuk memberikan ulasan.
                </div>
            @endauth

        </div>
    </div>
</div>
@endsection