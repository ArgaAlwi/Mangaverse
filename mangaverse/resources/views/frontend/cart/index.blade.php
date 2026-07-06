@extends('layouts.master')

@section('title', 'Keranjang Belanja - Mangaverse')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold m-0"><i class="fa-solid fa-cart-shopping text-primary me-3"></i>Keranjang Belanja</h3>
        <span class="badge bg-primary bg-opacity-10 text-primary ms-3 rounded-pill px-3 py-2">{{ $carts->count() }} Item</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3" colspan="2">Produk Komik</th>
                                    <th class="text-center">Harga Satuan</th>
                                    <th class="text-center" width="120">Jumlah</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0; @endphp
                                @forelse($carts as $cartItem)
                                    @php 
                                        $subtotal = $cartItem->comic->price * $cartItem->quantity;
                                        $totalPrice += $subtotal;
                                    @endphp
                                    <tr>
                                        <td class="ps-4 py-3" width="80">
                                            <img src="{{ $cartItem->comic->cover ? asset('storage/'.$cartItem->comic->cover) : 'https://dummyimage.com/60x80' }}" class="rounded shadow-sm" style="width: 60px; height: 85px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <a href="{{ route('comics.show', $cartItem->comic->id) }}" class="text-decoration-none text-dark fw-bold d-block mb-1">{{ $cartItem->comic->title }}</a>
                                            <small class="text-muted d-block">Stok Tersedia: {{ $cartItem->comic->stock }}</small>
                                            
                                            <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm text-danger p-0 fw-bold" onclick="return confirm('Hapus komik ini dari keranjang?')">
                                                    <i class="fa-solid fa-trash-can me-1"></i>Hapus
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center text-muted">Rp {{ number_format($cartItem->comic->price, 0, ',', '.') }}</td>
                                        <td class="text-center fw-bold">{{ $cartItem->quantity }}</td>
                                        <td class="text-end pe-4 fw-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" width="120" class="opacity-50 mb-3">
                                            <h5 class="fw-bold text-muted">Keranjang masih kosong</h5>
                                            <p class="text-muted mb-4">Yuk, cari komik favoritmu sekarang!</p>
                                            <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="fa-solid fa-magnifying-glass me-2"></i>Mulai Belanja</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Barang</span>
                        <span class="fw-bold">{{ $carts->sum('quantity') }} Item</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4 border-bottom pb-3">
                        <span class="text-muted">Total Harga</span>
                        <span class="fw-bold">Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total Bayar</span>
                        <span class="fw-bold fs-5 text-primary">Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
                    </div>

                    @if($carts->count() > 0)
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm" style="background-color: var(--mv-blue); border:none;">
                            Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    @else
                        <button class="btn btn-secondary w-100 rounded-pill fw-bold py-2" disabled>Keranjang Kosong</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection