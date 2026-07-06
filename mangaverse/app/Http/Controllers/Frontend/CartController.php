<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function index()
    {
        $carts = Cart::with('comic')->where('user_id', Auth::id())->get();
        return view('frontend.cart.index', compact('carts'));
    }

    // Menambahkan komik ke keranjang
    public function store(Request $request, $comic_id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $comic = Comic::findOrFail($comic_id);

        // Cek stok apakah mencukupi
        if ($request->quantity > $comic->stock) {
            return back()->with('error', 'Stok komik tidak mencukupi!');
        }

        // Cek apakah komik sudah ada di keranjang user
        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('comic_id', $comic_id)
                            ->first();

        if ($existingCart) {
            // Jika sudah ada, tambahkan quantity-nya
            $newQuantity = $existingCart->quantity + $request->quantity;
            if ($newQuantity > $comic->stock) {
                return back()->with('error', 'Total kuantitas melebihi stok yang tersedia!');
            }
            $existingCart->update(['quantity' => $newQuantity]);
        } else {
            // Jika belum ada, buat baru
            Cart::create([
                'user_id' => Auth::id(),
                'comic_id' => $comic_id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Komik berhasil ditambahkan ke keranjang!');
    }

    // Menghapus komik dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        return back()->with('success', 'Komik dihapus dari keranjang.');
    }
}