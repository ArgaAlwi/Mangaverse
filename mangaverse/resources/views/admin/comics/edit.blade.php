@extends('layouts.admin')

@section('title', 'Edit Komik')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0">Edit Komik: {{ $comic->title }}</h3>
    <a href="{{ route('admin.comics.index') }}" class="btn btn-outline-secondary fw-bold">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-xl-9 col-lg-10">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.comics.update', $comic->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Informasi Dasar</h5>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Judul Komik *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $comic->title) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pengarang *</label>
                            <select name="author_id" class="form-select" required>
                                <option value="">-- Pilih Pengarang --</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ (old('author_id', $comic->author_id) == $author->id) ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Penerbit *</label>
                            <select name="publisher_id" class="form-select" required>
                                <option value="">-- Pilih Penerbit --</option>
                                @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" {{ (old('publisher_id', $comic->publisher_id) == $publisher->id) ? 'selected' : '' }}>{{ $publisher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Genre *</label>
                        <select name="genres[]" class="form-select" multiple required style="height: 120px;">
                            @php
                                $selectedGenres = $comic->genres->pluck('id')->toArray();
                            @endphp
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" {{ in_array($genre->id, old('genres', $selectedGenres)) ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Tahan tombol CTRL/CMD untuk memilih lebih dari satu.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Sinopsis *</label>
                        <textarea name="synopsis" class="form-control" rows="4" required>{{ old('synopsis', $comic->synopsis) }}</textarea>
                    </div>

                    <h5 class="fw-bold mb-3 text-primary border-bottom pb-2 mt-5">Detail Produk & Harga</h5>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $comic->isbn) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tahun Terbit *</label>
                            <input type="number" name="published_year" class="form-control" value="{{ old('published_year', $comic->published_year) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Jumlah Halaman *</label>
                            <input type="number" name="pages" class="form-control" value="{{ old('pages', $comic->pages) }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Berat (Gram) *</label>
                            <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $comic->weight) }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Harga (Rp) *</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $comic->price) }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Diskon (%)</label>
                            <input type="number" name="discount" class="form-control" value="{{ old('discount', $comic->discount) }}" min="0" max="100">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Stok *</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $comic->stock) }}" required>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 text-primary border-bottom pb-2 mt-5">Media</h5>
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            <img src="{{ $comic->cover ? asset('storage/'.$comic->cover) : 'https://dummyimage.com/150x200/ccc/fff' }}" class="img-thumbnail" style="width: 100px; height: 140px; object-fit:cover;" alt="Cover Saat Ini">
                            <small class="d-block mt-1 text-muted">Cover Saat Ini</small>
                        </div>
                        <div class="col-md-10">
                            <label class="form-label fw-bold">Ganti Cover Komik (Opsional)</label>
                            <input type="file" name="cover" class="form-control" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti cover. Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="fa-solid fa-save me-1"></i> Update Komik
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection