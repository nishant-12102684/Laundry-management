<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Category;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::paginate(10); // Paginate orders (adjust number as needed)
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $categories = Category::all();
        return view('orders.create', compact('categories'));
    }

    /**
     * Store a newly created order in the database.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string',
        'category_id' => 'required|array',
        'category_id.*' => 'exists:categories,id',
        'quantity' => 'required|array',
        'quantity.*' => 'integer|min:1',
    ]);

    $customer = Customer::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    $totalAmount = 0;
    foreach ($request->category_id as $index => $categoryId) {
        $category = Category::find($categoryId);
        $quantity = $request->quantity[$index];
        $itemTotal = $category->price_per_unit * $quantity;
        $totalAmount += $itemTotal;

        $order = Order::create([
            'customer_id' => $customer->id,
            'category_id' => $categoryId,
            'quantity' => $quantity,
            'total_amount' => $itemTotal,
            'status' => 'pending',
        ]);
    }

    // Optionally, you can create an entry in the orders table with the total amount for reference
    // Or save this information elsewhere for reporting.

    return redirect()->route('orders.index')->with('success', 'Order created successfully!');
}


    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,delivered',
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated!');
    }
}
