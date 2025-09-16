<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'email',
        'phone',
        'shipping_address',
        'city',
        'postal_code',
        'total',
        'status'
    ];

    public function details()
    {
        return $this->hasMany(order_details::class);
    }
}
