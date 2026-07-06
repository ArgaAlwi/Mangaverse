<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Comic;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total pendapatan (hanya dari pesanan yang sudah dibayar)
        $totalRevenue = Order::where('payment_status', 'Paid')->sum('total_amount');
        
        // Menghitung total data lainnya
        $totalOrders = Order::count();
        $totalComics = Comic::count();
        $totalUsers = User::count();

        // Mengambil 5 pesanan terakhir yang masuk
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalRevenue', 'totalOrders', 'totalComics', 'totalUsers', 'recentOrders'));
    }
}