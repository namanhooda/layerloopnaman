<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_code',
        'shipment_id',
        'shipment_from',
        'shipment_order_id',
        'user_id',
        'order_date',
        'address_id',
        'total_quantity',
        'sub_total',
        'total',
        'payment_mod',
        'shipping_type',
        'shipping_charges',
        'coupon_applied',
        'coupon_code',
        'coupon_discount',
        'order_notes',
        'status',
        'cancel_reason',
        'cancel_note',
        'razorpay_order_id',
        'payment_id',
        'payment_status',
        'items',
        'raw_response',
        'raw_response',
        'order_from',
        'created_at',
        'updated_at',
    ];
protected $casts = [
    'order_date' => 'datetime',
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
    public function itemsData()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
