<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'weight',
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke tabel Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
