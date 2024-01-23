<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'products_id',
        'url'
    ];

    public function getUrlAttribute($url)
    {

        $baseUrl = rtrim(config('app.url'), '/'); // Remove trailing slash from the base URL
        $url = ltrim(Storage::url($url), '/'); // Remove leading slash from the Storage URL

        return $baseUrl . '/' . $url;
    }
}
