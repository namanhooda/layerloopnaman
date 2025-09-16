<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'featured_image', 'meta_title', 'meta_description',
        'tags', 'category_id', 'author_name', 'content',
        'status', 'publish_at', 'seo_schema','meta_data'
    ];

    protected $casts = [
        'seo_schema' => 'array',
        'publish_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

}
