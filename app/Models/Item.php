<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'jewelry_type', 'size', 'metal', 'weight', 
        'price', 'qty', 'total', 'discount', 'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function carats()
    {
        return $this->hasMany(Carat::class, 'item_id', 'id');
    }
}
