<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    // Menampilkan halaman detail komik beserta ulasannya
    public function show(string $id)
    {
        // Ambil data komik beserta author, publisher, dan semua reviews-nya
        $comic = Comic::with(['author', 'publisher', 'reviews.user'])->findOrFail($id);
        
        return view('frontend.comics.show', compact('comic'));
    }
}