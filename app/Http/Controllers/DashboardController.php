<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with order statistics, revenue, and recent orders.
     */
    public function index()
    {
        // Get counts for different order statuses
        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        // Calculate total revenue from completed and delivered orders
        $totalRevenue = Order::whereIn('status', ['delivered', 'completed'])
            ->sum('total_amount');

        // Fetch recent orders with relationships
        $recentOrders = Order::with(['customer', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // Calculate revenue by category
        $revenueByCategory = Order::whereIn('status', ['delivered', 'completed'])
            ->select('categories.name', DB::raw('SUM(orders.total_amount) as total'))
            ->join('categories', 'categories.id', '=', 'orders.category_id')
            ->groupBy('categories.name')
            ->get();

        // Pass data to the view
        return view('dashboard', compact(
            'orderStats',
            'totalRevenue',
            'recentOrders',
            'revenueByCategory'
        ));
    }
}
