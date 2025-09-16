<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'mobile_image',
        'url',
        'title',
        'sub_title',
        'price_title',
        'price',
    ];
}
