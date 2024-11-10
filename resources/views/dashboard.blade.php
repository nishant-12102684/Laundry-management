@extends('layouts.app')

@section('content')
<div class="container">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-header {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .dashboard-title {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #4b5563;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .stat-card .number {
            color: #1f2937;
            font-size: 24px;
            font-weight: bold;
        }

        .stat-card.revenue .number {
            color: #059669;
        }

        .orders-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th,
        .orders-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .orders-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #4b5563;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-processing { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-delivered { background-color: #dcfce7; color: #166534; }

        .category-revenue {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .category-item:last-child {
            border-bottom: none;
        }
    </style>

    <div class="dashboard-header">
        <h1 class="dashboard-title">Laundry Dashboard</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Pending Orders</h3>
            <div class="number">{{ $orderStats['pending'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>Processing Orders</h3>
            <div class="number">{{ $orderStats['processing'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>Completed Orders</h3>
            <div class="number">{{ $orderStats['completed'] ?? 0 }}</div>
        </div>
        <div class="stat-card revenue">
            <h3>Total Revenue</h3>
            <div class="number">₹{{ number_format($totalRevenue ?? 0, 2) }}</div>
        </div>
    </div>

    <div class="orders-section">
        <h2 class="dashboard-title">Recent Orders</h2>
        @if(isset($recentOrders) && $recentOrders->count() > 0)
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                <span class="status-badge {{ 'status-' . strtolower($order->status) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No recent orders found.</p>
        @endif
    </div>
</div>
@endsection
