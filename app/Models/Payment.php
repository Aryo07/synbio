<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'user_id',
        'image',
    ];

    // Relasi dengan tabel Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // Relasi dengan tabel User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
