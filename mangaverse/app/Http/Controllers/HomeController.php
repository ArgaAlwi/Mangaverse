<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Memulai query ke tabel komik
        $query = Comic::query();

        // Jika ada input 'search' dari URL, lakukan pencarian berdasarkan judul
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Ambil data komik terbaru dengan pagination (misal 12 komik per halaman)
        $comics = $query->latest()->paginate(12);

        // Menyiapkan variabel kata kunci untuk ditampilkan kembali di form
        $keyword = $request->search;

        return view('frontend.home', compact('comics', 'keyword'));
    }
}