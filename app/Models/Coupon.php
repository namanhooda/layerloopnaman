<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'type', 'value', 'min_cart_value',
        'start_date', 'end_date', 'max_usage', 'used', 'is_active'
    ];
}
