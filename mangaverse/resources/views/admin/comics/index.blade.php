@extends('layouts.admin')

@section('title', 'Data Komik')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0">Katalog Komik</h3>
    <a href="{{ route('admin.comics.create') }}" class="btn btn-primary fw-bold" style="background-color: var(--mv-blue); border:none;">
        <i class="fa-solid fa-plus me-1"></i> Tambah Komik
    </a>
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
                        <th class="ps-4 py-3">Buku</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comics as $comic)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ $comic->cover ? asset('storage/'.$comic->cover) : 'https://dummyimage.com/50x70/ccc/fff' }}" class="rounded shadow-sm me-3" style="width: 50px; height: 70px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $comic->title }}</h6>
                                    <small class="text-muted"><i class="fa-solid fa-pen-nib me-1"></i>{{ $comic->author->name }} | {{ $comic->publisher->name }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($comic->price, 0, ',', '.') }}</td>
                        <td>{{ $comic->stock }} Pcs</td>
                        <td>
                            @if($comic->stock > 0)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success">Available</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Sold Out</span>
                            @endif
                        <td class="text-end pe-4">
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.comics.edit', $comic->id) }}" class="btn btn-sm btn-outline-warning rounded-circle me-1" title="Edit">
            <i class="fa-solid fa-pen"></i>
        </a>
        
        <form action="{{ route('admin.comics.destroy', $comic->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komik {{ $comic->title }} ini? Gambar cover-nya juga akan terhapus.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data komik.</td>
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