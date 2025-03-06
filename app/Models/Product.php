<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'weight',
        'price',
        'status'
    ];

    // Relasi ke tabel Cart
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }
}
