<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Menambahkan ini agar VS Code paham

class ReviewController extends Controller
{
    // Menambahkan tipe data 'string' di depan $comic_id
    public function store(Request $request, string $comic_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        // Simpan ulasan ke database
        Review::create([
            'user_id' => Auth::id(), // Menggunakan Auth::id() agar tidak digaris merah
            'comic_id' => $comic_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan kamu berhasil ditambahkan.');
    }
}