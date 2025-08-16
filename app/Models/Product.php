<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'code',
        'barcode',
        'description',
        'price',
        'discounted_price',
        'stock_quantity',
        'charge_tax',
        'in_stock',
        'featured_image',
        'image_path',
        'variant_option',
        'category',
        'status',
        'tags',
    ];
    public function wishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }
}
