<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = ['prototype_id','name', 'slug','status'];

    public function prototype()
    {
        return $this->belongsTo(Prototype::class, 'prototype_id');
    }
    
}
