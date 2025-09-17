<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class order_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variation',
        'quantity',
        'price'
    ];

    public function order()
    {
        return $this->belongsTo(order_details::class);
    }
}
