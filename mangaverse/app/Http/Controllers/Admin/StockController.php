<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Menampilkan semua komik dan jumlah stoknya
    public function index()
    {
        $comics = Comic::latest()->paginate(10);
        return view('admin.stock.index', compact('comics'));
    }

    // Mengupdate stok komik secara cepat
    public function update(Request $request, string $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $comic = Comic::findOrFail($id);
        $comic->update([
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', "Stok komik \"{$comic->title}\" berhasil diperbarui!");
    }
}