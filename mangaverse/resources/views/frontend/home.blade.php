@extends('layouts.master')

@section('title', 'Katalog Komik Mangaverse')

@section('content')
<div class="container py-5">
    <div class="row mb-5 align-items-center bg-light rounded-4 p-4 shadow-sm border">
        <div class="col-md-8 text-center text-md-start mb-4 mb-md-0">
            <h2 class="fw-bold mb-2">Selamat Datang di <span style="color: var(--mv-blue);">Mangaverse</span>! 📚</h2>
            <p class="text-muted mb-0 fs-6">Temukan dan koleksi seri komik manga favoritmu dari berbagai genre dengan harga terbaik. Mulai petualangan membacamu hari ini.</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="fa-solid fa-book-open-reader opacity-25" style="font-size: 5rem; color: var(--mv-blue);"></i>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8 col-lg-6">
            <form action="{{ route('home') }}" method="GET">
                <div class="input-group shadow-sm rounded-pill overflow-hidden border border-2">
                    <input type="text" name="search" class="form-control border-0 px-4 py-3" placeholder="Cari judul komik favoritmu di sini..." value="{{ $keyword ?? '' }}">
                    <button class="btn btn-primary px-4 fw-bold" type="submit" style="background-color: var(--mv-blue); border:none;">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Cari
                    </button>
                </div>
            </form>

            @if(isset($keyword) && $keyword != '')
                <div class="text-center mt-3">
                    <p class="text-muted">Menampilkan hasil pencarian untuk: <strong class="text-dark">"{{ $keyword }}"</strong></p>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fa-solid fa-xmark me-1"></i>Hapus Filter Pencarian</a>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h4 class="fw-bold m-0"><i class="fa-solid fa-fire text-danger me-2"></i>Katalog Terbaru</h4>
    </div>

    <div class="row g-4">
        @forelse($comics as $comic)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden text-decoration-none">
                    <img src="{{ $comic->cover ? asset('storage/'.$comic->cover) : 'https://dummyimage.com/300x400' }}" class="card-img-top" alt="{{ $comic->title }}" style="height: 320px; object-fit: cover;">
                    
                    <div class="card-body p-3 d-flex flex-column">
                        <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $comic->title }}">{{ $comic->title }}</h6>
                        
                        <small class="text-muted mb-2 text-truncate d-block">
                            <i class="fa-solid fa-pen-nib me-1" style="font-size: 0.7rem;"></i> 
                            {{ is_object($comic->author) ? $comic->author->name : ($comic->author ?? 'Tanpa Pengarang') }}
                        </small>
                        
                        <h5 class="fw-bold mt-auto mb-3" style="color: var(--mv-blue);">Rp {{ number_format($comic->price, 0, ',', '.') }}</h5>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('comics.show', $comic->id) }}" class="btn btn-outline-primary btn-sm rounded-pill fw-bold">
                                <i class="fa-solid fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm border">
                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="100" class="mb-3 opacity-50">
                <h5 class="fw-bold text-muted">Komik Tidak Ditemukan</h5>
                <p class="text-muted">Maaf, kami tidak menemukan komik dengan judul <strong class="text-dark">"{{ $keyword }}"</strong>.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $comics->appends(['search' => $keyword])->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection