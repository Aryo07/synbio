<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $table = 'couriers';

    protected $fillable = [
        'name',
        'service',
        'cost',
    ];

    // Relasi ke tabel Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'courier_id', 'id');
    }
}
