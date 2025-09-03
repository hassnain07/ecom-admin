<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    use HasFactory;

     protected $fillable = [
        'path'
    ];
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
