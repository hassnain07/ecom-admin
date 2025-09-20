<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;

    public function deliveryCharges()
    {
        return $this->hasOne(DeliveryCharges::class, 'store_id');
    }
}
