<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'seller_id',
        'customer_name',
        'customer_surname',
        'customer_phone',
        'customer_email',
        'customer_birthdate',
        'total',
        'discount',
        'subtotal'
    ];

    // ความสัมพันธ์ไปยัง stores
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    // ความสัมพันธ์ไปยัง sellers
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    // ความสัมพันธ์ไปยัง items
    public function items()
    {
        return $this->hasMany(Item::class, 'order_id', 'id');
    }

}
