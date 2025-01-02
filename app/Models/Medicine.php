<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
        'price',
    ];  

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
    
    // Scope attribute for price range
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice])
                     ->orWhere('price', $minPrice)
                     ->orWhere('price', $maxPrice);
    }
}