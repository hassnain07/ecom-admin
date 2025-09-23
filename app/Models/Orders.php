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
        return $this->hasMany(order_details::class, 'order_id', 'id');
    }

    public function orders()
{
    return $this->hasMany(\App\Models\Order::class, 'user_id'); 
    // 👆 replace 'user_id' with the actual foreign key column in orders table
}
}
