<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ComicController extends Controller
{
    public function index()
    {
        // Mengambil data komik terbaru beserta relasi author & publisher
        $comics = Comic::with(['author', 'publisher'])->latest()->paginate(10);
        return view('admin.comics.index', compact('comics'));
    }

    public function create()
    {
        // Mengambil master data untuk dropdown form
        $authors = Author::orderBy('name', 'ASC')->get();
        $publishers = Publisher::orderBy('name', 'ASC')->get();
        $genres = Genre::orderBy('name', 'ASC')->get();
        
        return view('admin.comics.create', compact('authors', 'publishers', 'genres'));
    }

    public function store(Request $request)
    {
        // Validasi data dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'cover' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'synopsis' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'genres' => 'required|array',
            'isbn' => 'nullable|string|unique:comics,isbn',
            'published_year' => 'required|integer',
            'pages' => 'required|integer',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
        ]);

        // Upload gambar cover ke storage/app/public/comics
        $coverPath = $request->file('cover')->store('comics', 'public');

        // Simpan data komik
        $comic = Comic::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title . '-' . time()), // Tambah time() agar slug unik
            'cover' => $coverPath,
            'synopsis' => $request->synopsis,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'isbn' => $request->isbn,
            'published_year' => $request->published_year,
            'pages' => $request->pages,
            'weight' => $request->weight,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'Available' : 'Out of Stock',
        ]);

        // Simpan relasi genre (Tabel Pivot)
        $comic->genres()->attach($request->genres);

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil ditambahkan ke katalog!');
    }

    // (Metode edit, update, destroy akan kita buat di bagian selanjutnya agar tidak terlalu panjang)
    public function edit(string $id)
    {
        $comic = Comic::with('genres')->findOrFail($id);
        $authors = Author::orderBy('name', 'ASC')->get();
        $publishers = Publisher::orderBy('name', 'ASC')->get();
        $genres = Genre::orderBy('name', 'ASC')->get();
        
        return view('admin.comics.edit', compact('comic', 'authors', 'publishers', 'genres'));
    }

    public function update(Request $request, string $id)
    {
        $comic = Comic::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Cover boleh kosong saat edit
            'synopsis' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'genres' => 'required|array',
            'isbn' => 'nullable|string|unique:comics,isbn,'.$comic->id, // Abaikan validasi unik untuk komik ini sendiri
            'published_year' => 'required|integer',
            'pages' => 'required|integer',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
        ]);

        $data = $request->except(['cover', 'genres']);
        $data['slug'] = Str::slug($request->title . '-' . time());
        $data['status'] = $request->stock > 0 ? 'Available' : 'Out of Stock';

        // Cek jika ada gambar cover baru yang diupload
        if ($request->hasFile('cover')) {
            // Hapus gambar lama jika ada
            if ($comic->cover && Storage::disk('public')->exists($comic->cover)) {
                Storage::disk('public')->delete($comic->cover);
            }
            // Simpan gambar baru
            $data['cover'] = $request->file('cover')->store('comics', 'public');
        }

        $comic->update($data);
        $comic->genres()->sync($request->genres); // Sync akan mengupdate data di tabel pivot

        return redirect()->route('admin.comics.index')->with('success', 'Data komik berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $comic = Comic::findOrFail($id);

        // Hapus gambar fisik dari storage
        if ($comic->cover && Storage::disk('public')->exists($comic->cover)) {
            Storage::disk('public')->delete($comic->cover);
        }

        $comic->delete(); // Hapus data dari database

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil dihapus!');
    }
}
