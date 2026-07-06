@extends('layouts.admin')

@section('title', 'Kelola Pesanan ' . $order->invoice_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0">Kelola Pesanan</h3>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary fw-bold rounded-pill">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white pt-4 pb-2 px-4 border-bottom-0 d-flex justify-content-between">
                <div>
                    <small class="text-muted">No. Invoice</small>
                    <h5 class="fw-bold m-0 text-primary">{{ $order->invoice_number }}</h5>
                </div>
                <div class="text-end">
                    <small class="text-muted">Tanggal</small>
                    <h6 class="m-0 fw-bold">{{ $order->created_at->format('d M Y, H:i') }}</h6>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-muted mb-2">Informasi Pembeli</h6>
                        <p class="mb-1 fw-bold">{{ $order->recipient_name }}</p>
                        <p class="mb-1 small"><i class="fa-solid fa-phone me-1"></i> {{ $order->phone_number }}</p>
                        <p class="mb-1 small text-muted">{{ $order->shipping_address }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold text-muted mb-2">Informasi Pengiriman</h6>
                        <p class="mb-1 small"><i class="fa-solid fa-truck me-1"></i> Kurir: <strong>{{ $order->courier }}</strong></p>
                        <p class="mb-1 small">Metode Bayar: <strong>{{ $order->payment_method }}</strong></p>
                        <p class="mb-0 mt-2">
                            Status Bayar: 
                            @if($order->payment_status == 'Paid')
                                <span class="badge bg-success ms-1">Paid</span>
                            @else
                                <span class="badge bg-danger ms-1">Unpaid</span>
                            @endif
                        </p>
                    </div>
                </div>

                <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">Produk yang Dibeli</h6>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td width="60">
                                    <img src="{{ $item->comic->cover ? asset('storage/'.$item->comic->cover) : 'https://dummyimage.com/50' }}" class="rounded shadow-sm" style="width: 40px; height: 60px; object-fit: cover;">
                                </td>
                                <td>
                                    <h6 class="mb-0 fw-bold">{{ $item->comic->title }}</h6>
                                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                </td>
                                <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end text-muted small pt-3">Subtotal:</td>
                                <td class="text-end fw-bold pt-3">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end text-muted small">Ongkos Kirim:</td>
                                <td class="text-end fw-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end fw-bold fs-6">Total Pembayaran:</td>
                                <td class="text-end fw-bold fs-6 text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
            <div class="card-header bg-white pt-4 pb-2 px-4 border-bottom-0">
                <h6 class="fw-bold m-0"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Update Pesanan</h6>
            </div>
            <div class="card-body p-4 pt-3">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Status Pesanan</label>
                        <select name="order_status" class="form-select border-2">
                            <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu Bayar)</option>
                            <option value="Processing" {{ $order->order_status == 'Processing' ? 'selected' : '' }}>Processing (Sedang Diproses)</option>
                            <option value="Shipped" {{ $order->order_status == 'Shipped' ? 'selected' : '' }}>Shipped (Dalam Pengiriman)</option>
                            <option value="Delivered" {{ $order->order_status == 'Delivered' ? 'selected' : '' }}>Delivered (Selesai/Diterima)</option>
                            <option value="Cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Nomor Resi (Tracking Number)</label>
                        <input type="text" name="tracking_number" class="form-control border-2" value="{{ $order->tracking_number }}" placeholder="Kosongkan jika belum dikirim">
                        <small class="text-muted" style="font-size: 0.7rem;">Isi nomor resi saat pesanan diubah ke status 'Shipped'.</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill" style="background-color: var(--mv-blue); border:none;">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection