@extends('layouts.master')

@section('title', 'Checkout Pesanan')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Pengiriman & Pembayaran</h2>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                        <h5 class="fw-bold m-0"><i class="fa-solid fa-location-dot text-danger me-2"></i>Alamat Pengiriman</h5>
                    </div>
                    <div class="card-body px-4 pb-4 pt-2">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nama Penerima</label>
                                <input type="text" name="recipient_name" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nomor WhatsApp / HP</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ Auth::user()->phone }}" required placeholder="Contoh: 08123456789">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Alamat Lengkap (Sertakan RT/RW, Desa, Kecamatan, Kota)</label>
                                <textarea name="shipping_address" class="form-control" rows="3" required>{{ Auth::user()->address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold border-bottom pb-2"><i class="fa-solid fa-truck-fast text-primary me-2"></i>Pilih Kurir</h5>
                                <div class="mt-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input courier-radio" type="radio" name="courier" value="JNE REG" data-cost="25000" id="kurir1" required checked>
                                        <label class="form-check-label d-flex justify-content-between" for="kurir1">
                                            <span>JNE Reguler (2-3 Hari)</span>
                                            <span class="fw-bold">Rp 25.000</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input courier-radio" type="radio" name="courier" value="JNE OKE" data-cost="15000" id="kurir2">
                                        <label class="form-check-label d-flex justify-content-between" for="kurir2">
                                            <span>JNE OKE (4-5 Hari)</span>
                                            <span class="fw-bold">Rp 15.000</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input courier-radio" type="radio" name="courier" value="J&T Express" data-cost="20000" id="kurir3">
                                        <label class="form-check-label d-flex justify-content-between" for="kurir3">
                                            <span>J&T Express (2-3 Hari)</span>
                                            <span class="fw-bold">Rp 20.000</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input courier-radio" type="radio" name="courier" value="GoSend Instant" data-cost="40000" id="kurir4">
                                        <label class="form-check-label d-flex justify-content-between" for="kurir4">
                                            <span>GoSend Instant (Hari Ini)</span>
                                            <span class="fw-bold text-success">Rp 40.000</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold border-bottom pb-2"><i class="fa-solid fa-wallet text-success me-2"></i>Metode Pembayaran</h5>
                                <div class="mt-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" value="Transfer Bank BCA" id="pay1" required checked>
                                        <label class="form-check-label fw-bold" for="pay1">Transfer Bank BCA</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" value="QRIS" id="pay2">
                                        <label class="form-check-label fw-bold" for="pay2">QRIS (Gopay/OVO/Dana)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" value="E-Wallet GoPay" id="pay3">
                                        <label class="form-check-label fw-bold" for="pay3">E-Wallet GoPay</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" value="COD" id="pay4">
                                        <label class="form-check-label fw-bold" for="pay4">Bayar di Tempat (COD)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold border-bottom pb-3 mb-3">Pesanan Anda</h5>
                        
                        <div class="mb-4" style="max-height: 250px; overflow-y: auto;">
                            @php $subtotal = 0; @endphp
                            @foreach($carts as $cart)
                                @php 
                                    $hargaFinal = $cart->comic->discount > 0 ? $cart->comic->price - ($cart->comic->price * ($cart->comic->discount / 100)) : $cart->comic->price;
                                    $subtotal += $hargaFinal * $cart->quantity;
                                @endphp
                                <div class="d-flex align-items-center mb-3">
                                    <div class="position-relative me-3">
                                        <img src="{{ $cart->comic->cover ? asset('storage/'.$cart->comic->cover) : 'https://dummyimage.com/50' }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">{{ $cart->quantity }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fs-6 text-truncate" style="max-width: 180px;">{{ $cart->comic->title }}</h6>
                                        <small class="text-muted">Rp {{ number_format($hargaFinal, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Subtotal Produk</span>
                            <span id="display-subtotal" data-value="{{ $subtotal }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Ongkos Kirim</span>
                            <span id="display-shipping">Rp 25.000</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-4">
                            <span class="fw-bold fs-5">Total Akhir</span>
                            <span class="fw-bold fs-4" style="color: var(--mv-blue);" id="display-total">Rp {{ number_format($subtotal + 25000, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm" style="background-color: var(--mv-blue); border:none;">
                            Buat Pesanan Sekarang <i class="fa-solid fa-check ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Script untuk update total harga secara real-time saat kurir dipilih
    document.querySelectorAll('.courier-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            let shippingCost = parseInt(this.getAttribute('data-cost'));
            let subtotal = parseInt(document.getElementById('display-subtotal').getAttribute('data-value'));
            let total = subtotal + shippingCost;
            
            // Format format uang (Rupiah) sederhana
            document.getElementById('display-shipping').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
            document.getElementById('display-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        });
    });
</script>
@endpush
@endsection