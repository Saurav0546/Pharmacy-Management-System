<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $appends = ['quantity'];

    protected $fillable = [
        'customer_name', 
        'order_date', 
        'total_price',
    ];

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)->withPivot('quantity');
    }

    // Quantity attribute
    public function getQuantityAttribute() {
        return $this->attributes['quantity'];
    }
}