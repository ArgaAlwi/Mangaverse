@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0">Daftar Pesanan Masuk</h3>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">No. Invoice</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 py-3 fw-bold">{{ $order->invoice_number }}</td>
                        <td>{{ $order->recipient_name }}</td>
                        <td class="text-muted small">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @if($order->payment_status == 'Paid')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success">Paid</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Unpaid</span>
                            @endif
                        </td>
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
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary rounded-pill px-3" style="background-color: var(--mv-blue); border:none;">
                                Kelola
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top py-3">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection