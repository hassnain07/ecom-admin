<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'store_id',
        'status',
    ];


    // Relationships
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }

    public function ProductStatus()
    {
        return $this->belongsToMany(Statuses::class, 'product_statuses', 'product_id', 'status_id')
            ->withPivot('user_id', 'sale_price')
            ->withTimestamps();
    }

    public function latestStatus()
    {
        return $this->hasOne(ProductStatus::class, 'product_id')->latestOfMany();
    }


    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id')
                    ->with('user:id,name'); // eager load reviewer info
    }
}
