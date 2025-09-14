<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];


    // Each item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Each item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
