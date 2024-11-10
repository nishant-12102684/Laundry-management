<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'category_id',
        'quantity',
        'total_amount',
        'status'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_DELIVERED = 'delivered';

    /**
     * Get the customer that owns the order.
     */
    public function customer()
{
    return $this->belongsTo(Customer::class);
}

public function category()
{
    return $this->belongsTo(Category::class);
}
    /**
     * Scope a query to only include orders with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Custom method to calculate the total revenue from this order.
     */
    public function calculateTotalRevenue()
    {
        return $this->quantity * $this->category->price_per_unit;
    }
}
