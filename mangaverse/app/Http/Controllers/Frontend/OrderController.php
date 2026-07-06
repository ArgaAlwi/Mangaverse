<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan customer
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('frontend.orders.index', compact('orders'));
    }

    // Menampilkan detail invoice & halaman pembayaran
    public function show(string $id)
    {
        $order = Order::with('items.comic')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('frontend.orders.show', compact('order'));
    }

    // Simulasi proses pembayaran
    public function pay(string $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($order->payment_status == 'Unpaid') {
            $order->update([
                'payment_status' => 'Paid',
                'order_status' => 'Processing' // Setelah dibayar, status langsung diproses
            ]);
            
            return back()->with('success', 'Pembayaran Berhasil! Pesanan Anda sedang diproses oleh tim Mangaverse.');
        }

        return back()->with('error', 'Pesanan ini sudah dibayar sebelumnya.');
    }
}