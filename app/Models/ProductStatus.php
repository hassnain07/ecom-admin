<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    use HasFactory;

     protected $fillable = [
        'product_id',
        'status_id',
        'user_id',
        'sale_price',
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function statuses()
    {
        return $this->belongsTo(statuses::class, 'status_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
