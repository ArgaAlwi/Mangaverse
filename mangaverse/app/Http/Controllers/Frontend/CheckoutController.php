<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('comic')->where('user_id', Auth::id())->get();
        
        // Jika keranjang kosong, kembalikan ke halaman sebelumnya
        if ($carts->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda masih kosong.');
        }

        return view('frontend.checkout.index', compact('carts'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'courier' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $carts = Cart::with('comic')->where('user_id', Auth::id())->get();
        
        if ($carts->count() == 0) {
            return redirect()->route('cart.index');
        }

        // Simulasi ongkir sederhana berdasarkan pilihan kurir
        $shipping_cost = 0;
        if ($request->courier == 'JNE OKE') $shipping_cost = 15000;
        elseif ($request->courier == 'JNE REG') $shipping_cost = 25000;
        elseif ($request->courier == 'J&T Express') $shipping_cost = 20000;
        elseif ($request->courier == 'GoSend Instant') $shipping_cost = 40000;

        // Gunakan DB Transaction agar jika ada error di tengah jalan, data tidak masuk setengah-setengah
        DB::beginTransaction();

        try {
            $subtotal = 0;
            $invoice_number = 'INV-' . date('Ymd') . '-' . strtoupper(uniqid());

            // 1. Buat Data Induk Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'invoice_number' => $invoice_number,
                'recipient_name' => $request->recipient_name,
                'phone_number' => $request->phone_number,
                'shipping_address' => $request->shipping_address,
                'courier' => $request->courier,
                'shipping_cost' => $shipping_cost,
                'payment_method' => $request->payment_method,
                'payment_status' => 'Unpaid',
                'order_status' => 'Pending',
                'subtotal' => 0, // Akan diupdate di bawah
                'total_amount' => 0, // Akan diupdate di bawah
            ]);

            // 2. Masukkan Item dari Keranjang ke Order Items & Kurangi Stok Komik
            foreach ($carts as $cart) {
                $hargaFinal = $cart->comic->discount > 0 
                    ? $cart->comic->price - ($cart->comic->price * ($cart->comic->discount / 100)) 
                    : $cart->comic->price;
                
                $itemSubtotal = $hargaFinal * $cart->quantity;
                $subtotal += $itemSubtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'comic_id' => $cart->comic_id,
                    'quantity' => $cart->quantity,
                    'price' => $hargaFinal,
                    'subtotal' => $itemSubtotal
                ]);

                // Kurangi stok komik
                $comic = Comic::find($cart->comic_id);
                $comic->decrement('stock', $cart->quantity);
            }

            // 3. Update total harga di Order
            $order->update([
                'subtotal' => $subtotal,
                'total_amount' => $subtotal + $shipping_cost
            ]);

            // 4. Kosongkan Keranjang User
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // Redirect ke halaman simulasi pembayaran (akan kita buat nanti)
            return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}