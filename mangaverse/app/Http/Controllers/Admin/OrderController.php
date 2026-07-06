<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan untuk dikelola Admin
    public function show(string $id)
    {
        $order = Order::with(['items.comic', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Mengupdate status pesanan dan nomor resi
    public function update(Request $request, string $id)
    {
        $request->validate([
            'order_status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        
        $order->update([
            'order_status' => $request->order_status,
            'tracking_number' => $request->tracking_number,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
    // Menampilkan halaman laporan penjualan
    public function report(Request $request)
    {
        // Default filter bulan ini jika tidak ada tanggal yang dipilih
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));

        // Ambil pesanan yang sudah dibayar pada rentang tanggal tersebut
        $orders = Order::with('user')
            ->where('payment_status', 'Paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        // Hitung total omset
        $totalEarnings = $orders->sum('total_amount');

        return view('admin.orders.report', compact('orders', 'startDate', 'endDate', 'totalEarnings'));
    }
}
