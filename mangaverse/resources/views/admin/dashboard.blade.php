@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold m-0">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
        <p class="text-muted mb-0">Berikut adalah ringkasan performa toko Mangaverse hari ini.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white" style="background: linear-gradient(135deg, var(--mv-blue) 0%, #2a5298 100%) !important;">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-white-50 fw-bold">Total Pendapatan</p>
                    <h4 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                </div>
                <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-wallet fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-muted fw-bold">Total Pesanan</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalOrders }} <span class="fs-6 text-muted fw-normal">Transaksi</span></h4>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-cart-shopping fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-muted fw-bold">Katalog Komik</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalComics }} <span class="fs-6 text-muted fw-normal">Buku</span></h4>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-book-open fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-muted fw-bold">Total Pengguna</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalUsers }} <span class="fs-6 text-muted fw-normal">Akun</span></h4>
                </div>
                <div class="bg-info bg-opacity-10 text-info rounded-circle p-3 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-users fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white pt-4 pb-2 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold m-0"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>5 Pesanan Terbaru</h6>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
    </div>
    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">No. Invoice</th>
                        <th>Customer</th>
                        <th>Waktu</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="ps-4 py-3 fw-bold text-primary">{{ $order->invoice_number }}</td>
                        <td>{{ $order->recipient_name }}</td>
                        <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                        <td class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @if($order->order_status == 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->order_status == 'Processing')
                                <span class="badge bg-info text-dark">Processing</span>
                            @elseif($order->order_status == 'Shipped')
                                <span class="badge bg-primary">Shipped</span>
                            @elseif($order->order_status == 'Delivered')
                                <span class="badge bg-success">Delivered</span>
                            @else
                                <span class="badge bg-secondary">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada transaksi masuk hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection