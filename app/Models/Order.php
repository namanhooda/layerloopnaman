<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address_id',
        'total',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function logs()
    {
        return $this->hasMany(OrderLog::class);
    }

    // Each order belongs to an address
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    // Each order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
