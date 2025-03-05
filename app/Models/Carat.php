<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carat extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'carat_size', 'shape', 'color', 'clarity', 'has_certificate'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
