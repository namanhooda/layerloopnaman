<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name',
        'site_description',
        'site_mobile',
        'site_email',
        'site_address',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'pinterest_url',
        'site_logo',      // 👈 if you’re uploading logo
        'favicon',        // 👈 if you have a favicon upload
    ];
}
