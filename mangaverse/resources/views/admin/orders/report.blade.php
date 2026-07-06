@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
    <div>
        <h3 class="fw-bold m-0">Laporan Penjualan</h3>
        <p class="text-muted mb-0">Filter transaksi berhasil berdasarkan rentang tanggal.</p>
    </div>
    <button onclick="window.print()" class="btn btn-primary fw-bold rounded-pill px-4" style="background-color: var(--mv-blue); border:none;">
        <i class="fa-solid fa-print me-1"></i> Cetak Laporan
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4 d-print-none">
    <div class="card-body p-4">
        <form action="{{ route('admin.orders.report') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold small text-muted">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small text-muted">Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary fw-bold w-100 rounded-pill">
                    <i class="fa-solid fa-filter me-1"></i> Filter Data
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
    <div class="d-none d-print-block text-center mb-4 border-bottom pb-3">
        <h2 class="fw-bold mb-1">MANGAVERSE BOOKSTORE</h2>
        <p class="mb-0 text-muted small">Sistem Informasi Penjualan Komik Online Berbasis Web</p>
        <p class="mb-0 text-muted x-small">Surakarta, Indonesia</p>
    </div>

    <div class="text-center mb-4">
        <h4 class="fw-bold mb-1">REKAPITULASI PENJUALAN KOMIK</h4>
        <p class="text-muted mb-0">Periode: {{ date('d M Y', strtotime($startDate)) }} s/d {{ date('d M Y', strtotime($endDate)) }}</p>
    </div>

    <div class="row g-3 mb-4 text-center justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="bg-light p-3 rounded-3 border">
                <small class="text-muted fw-bold d-block mb-1">TOTAL TRANSAKSI BERHASIL</small>
                <h5 class="fw-bold m-0 text-dark">{{ $orders->count() }} Transaksi</h5>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="bg-light p-3 rounded-3 border">
                <small class="text-muted fw-bold d-block mb-1">TOTAL OMSET PENDAPATAN</small>
                <h5 class="fw-bold m-0 text-success">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th width="50">No</th>
                    <th>No. Invoice</th>
                    <th>Nama Penerima</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode Pembayaran</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="fw-bold text-center">{{ $order->invoice_number }}</td>
                    <td>{{ $order->recipient_name }}</td>
                    <td class="text-center small text-muted">{{ $order->updated_at->format('d M Y, H:i') }}</td>
                    <td class="text-center small">{{ $order->payment_method }}</td>
                    <td class="text-end fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada data transaksi sukses pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
            @if($orders->count() > 0)
            <tfoot>
                <tr class="table-light fw-bold">
                    <td colspan="5" class="text-end py-3">GRAND TOTAL KESELURUHAN:</td>
                    <td class="text-end text-success py-3">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    <div class="d-none d-print-block mt-5 pt-4">
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-5">Surakarta, {{ date('d F Y') }}<br>Mengetahui, Manajer Toko</p>
                <p class="fw-bold border-bottom d-inline-block px-3 mb-0">{{ Auth::user()->name }}</p>
                <p class="text-muted small">NIP. Admin-Mangaverse</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mengatur style khusus saat dicetak agar rapi di kertas A4 */
    @media print {
        body {
            background-color: #fff !important;
            color: #000 !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }
    }
</style>
@endsection