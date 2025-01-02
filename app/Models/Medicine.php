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

    // Scope attribute for sorting
    public function scopeSortBy($query, $sortBy, $sortOrder)
    {
        return $query->orderBy($sortBy, $sortOrder);
    }
    // Scope attribute for searching
    public function scopeSearchByCustomerName($query, $customerName)
    {
        return $query->whereHas('orders', function ($query) use ($customerName) {
            $query->where('customer_name', '=', $customerName);
        });
    }
}