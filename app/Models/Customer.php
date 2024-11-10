<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address'];

    /**
     * Indicates if the model should be timestamped.
     * Laravel will automatically manage the created_at and updated_at columns.
     *
     * @var bool
     */
    public $timestamps = true; // Optional; defaults to true

    /**
     * Define the relationship with the Order model.
     * A customer can have many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Custom method to fetch completed orders for a customer.
     * Useful if you want to get specific data like completed or pending orders.
     */
    public function completedOrders()
    {
        return $this->orders()->where('status', 'completed');
    }
}
