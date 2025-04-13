<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'available_products' => Product::where('quantity', '>', 0)->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_customers' => User::where('is_admin', false)->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
        ];

        $recent_orders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $low_stock_products = Product::where('quantity', '<', 10)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_products'));
    }
}
