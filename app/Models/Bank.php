<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_name',
        'image',
    ];

    // Relasi ke tabel Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'bank_id', 'id');
    }
}
