@extends('layouts.admin')

@section('title', 'Manajemen Stok Komik')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold m-0">Manajemen Stok Komik</h3>
    <p class="text-muted mb-0">Perbarui jumlah stok komik favorit dengan cepat di sini.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
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
                        <th class="ps-4 py-3" width="80">Cover</th>
                        <th>Judul Komik</th>
                        <th>Kategori / Genre</th>
                        <th class="text-center" width="150">Stok Saat Ini</th>
                        <th class="text-center" width="250">Aksi Perubahan Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comics as $comic)
                    <tr>
                        <td class="ps-4 py-2">
                            <img src="{{ $comic->cover ? asset('storage/'.$comic->cover) : 'https://dummyimage.com/40x60' }}" class="rounded shadow-sm" style="width: 40px; height: 55px; object-fit: cover;">
                        </td>
                        <td>
                            <h6 class="fw-bold mb-0 text-dark">{{ $comic->title }}</h6>
                            <small class="text-muted">{{ $comic->author->name ?? 'Tanpa Pengarang' }} | {{ $comic->publisher->name ?? 'Tanpa Penerbit' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $comic->category ?? 'Manga' }}</span>
                        </td>
                        <td class="text-center">
                            @if($comic->stock <= 5)
                                <span class="badge bg-danger fs-6 rounded-pill px-3">Sisa {{ $comic->stock }}</span>
                            @else
                                <span class="badge bg-success fs-6 rounded-pill px-3">{{ $comic->stock }}</span>
                            @endif
                        </td>
                        <td class="pe-4">
                            <form action="{{ route('admin.stock.update', $comic->id) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="stock" class="form-control form-control-sm text-center border-2" value="{{ $comic->stock }}" min="0" style="width: 80px;">
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 w-100" style="background-color: var(--mv-blue); border:none;">
                                    <i class="fa-solid fa-sync me-1"></i> Update
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data komik di katalog.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top py-3">
        {{ $comics->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection