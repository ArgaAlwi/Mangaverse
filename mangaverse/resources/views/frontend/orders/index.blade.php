@extends('layouts.master')

@section('title', 'Riwayat Pesanan Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h3 class="fw-bold mb-4">Riwayat Pesanan Saya <i class="fa-solid fa-box-open text-primary"></i></h3>

            @if($orders->count() > 0)
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">No. Invoice</th>
                                        <th>Tanggal</th>
                                        <th>Total Belanja</th>
                                        <th>Pembayaran</th>
                                        <th>Status Pesanan</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td class="ps-4 py-3 fw-bold">{{ $order->invoice_number }}</td>
                                        <td class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        <td class="fw-bold" style="color: var(--mv-blue);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->payment_status == 'Paid')
                                                <span class="badge bg-success">Sudah Dibayar</span>
                                            @else
                                                <span class="badge bg-danger">Belum Dibayar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->order_status == 'Pending')
                                                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                            @elseif($order->order_status == 'Processing')
                                                <span class="badge bg-info text-dark">Diproses</span>
                                            @elseif($order->order_status == 'Shipped')
                                                <span class="badge bg-primary">Dikirim</span>
                                            @elseif($order->order_status == 'Delivered')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-secondary">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td class="text-center pe-4">
                                            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/1008/1008010.png" width="120" class="mb-3 opacity-50">
                    <h5 class="text-muted fw-bold">Belum Ada Pesanan</h5>
                    <p class="text-muted">Anda belum melakukan transaksi apapun. Yuk, mulai belanja komik favoritmu!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4" style="background-color: var(--mv-blue); border:none;">Belanja Sekarang</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection