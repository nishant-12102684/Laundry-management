<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'price_per_unit'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true; // Optional if timestamps are needed

    /**
     * Define a relationship to the Order model.
     * Each category can have multiple orders.
     */
    public function orders()
{
    return $this->hasMany(Order::class);
}
}
