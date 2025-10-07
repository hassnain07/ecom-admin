<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCharges extends Model
{
    use HasFactory;


    protected $table = 'delivery_charges';

    protected $fillable = [
        'charges',
        'store_id',
    ];

    /**
     * Relation with Store
     */
    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }

    


}
