@extends('layouts.master')

@section('title', 'Detail Pesanan ' . $order->invoice_number)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Detail Pesanan</h3>
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary fw-bold rounded-pill">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                        <div>
                            <small class="text-muted d-block">Nomor Invoice</small>
                            <h5 class="fw-bold m-0" style="color: var(--mv-blue);">{{ $order->invoice_number }}</h5>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Tanggal Transaksi</small>
                            <span class="fw-bold">{{ $order->created_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h6 class="fw-bold text-muted mb-2">Info Pengiriman</h6>
                            <p class="mb-1 fw-bold">{{ $order->recipient_name }} ({{ $order->phone_number }})</p>
                            <p class="mb-1 text-muted small">{{ $order->shipping_address }}</p>
                            <p class="mb-0 text-muted small"><i class="fa-solid fa-truck me-1"></i> Kurir: <span class="fw-bold">{{ $order->courier }}</span></p>
                            @if($order->tracking_number)
                                <p class="mb-0 text-success small mt-1"><i class="fa-solid fa-barcode me-1"></i> Resi: <span class="fw-bold">{{ $order->tracking_number }}</span></p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted mb-2">Info Pembayaran</h6>
                            <p class="mb-1 text-muted small">Metode: <span class="fw-bold text-dark">{{ $order->payment_method }}</span></p>
                            <p class="mb-1 text-muted small">Status Pembayaran: 
                                @if($order->payment_status == 'Paid')
                                    <span class="badge bg-success ms-1">Sudah Dibayar</span>
                                @else
                                    <span class="badge bg-danger ms-1">Belum Dibayar</span>
                                @endif
                            </p>
                            <p class="mb-0 text-muted small">Status Pesanan: 
                                <span class="badge bg-info text-dark ms-1">{{ $order->order_status }}</span>
                            </p>
                        </div>
                    </div>

                    <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">Daftar Produk</h6>
                    <ul class="list-group list-group-flush mb-4">
                        @foreach($order->items as $item)
                        <li class="list-group-item px-0 py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->comic->cover ? asset('storage/'.$item->comic->cover) : 'https://dummyimage.com/50' }}" class="rounded shadow-sm me-3" style="width: 50px; height: 70px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $item->comic->title }}</h6>
                                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                </div>
                            </div>
                            <span class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <div class="bg-light p-3 rounded-3">
                        <div class="d-flex justify-content-between mb-2 small text-muted">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small text-muted">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Pembayaran</span>
                            <span class="fw-bold fs-5" style="color: var(--mv-blue);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                </div>
                
                @if($order->payment_status == 'Unpaid')
                <div class="card-footer bg-white border-top-0 p-4 pt-0 text-center">
                    <form action="{{ route('customer.orders.pay', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-lg w-100 rounded-pill fw-bold shadow-sm" onclick="return confirm('Lanjutkan simulasi pembayaran untuk pesanan ini?');">
                            <i class="fa-solid fa-money-bill-wave me-2"></i> Simulasi Bayar Sekarang
                        </button>
                    </form>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection