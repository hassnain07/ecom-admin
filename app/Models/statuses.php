<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statuses extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_statuses')
                    ->withPivot('user_id', 'sale_price')
                    ->withTimestamps();
    }
}
