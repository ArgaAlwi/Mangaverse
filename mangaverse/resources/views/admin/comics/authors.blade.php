@extends('layouts.admin')

@section('title', 'Data Pengarang & Penerbit')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold m-0">Data Pengarang & Penerbit</h3>
    <p class="text-muted mb-0">Daftar index pengarang dan penerbit komik yang terdaftar di sistem.</p>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white pt-4 px-4 border-bottom-0">
                <h5 class="fw-bold m-0 text-primary"><i class="fa-solid fa-pen-nib me-2"></i>Daftar Pengarang (Mangaka)</h5>
            </div>
            <div class="card-body px-4 pb-4">
                <ul class="list-group list-group-flush">
                    @forelse($authors as $author)
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">{{ $author->name }}</span>
                            <span class="badge bg-primary rounded-pill bg-opacity-10 text-primary">Active</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-4">Belum ada data pengarang komik.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white pt-4 px-4 border-bottom-0">
                <h5 class="fw-bold m-0 text-success"><i class="fa-solid fa-building me-2"></i>Daftar Penerbit</h5>
            </div>
            <div class="card-body px-4 pb-4">
                <ul class="list-group list-group-flush">
                    @forelse($publishers as $publisher)
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">{{ $publisher->name }}</span>
                            <span class="badge bg-success rounded-pill bg-opacity-10 text-success">Official Partner</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-4">Belum ada data penerbit komik.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection