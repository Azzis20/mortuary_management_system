<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Hasmany;

class Inventory extends Model
{
    //
     protected $fillable = [
        'item_name',
        'category',
        'stock_quantity',
        'min_threshold', 
       
    ];

     public function booking_item(): Hasmany
    {
        return $this->hasMany(BookingItem::class);
    }

    public function getStockStatusAttribute()
    {
        // 1. Check for Out of Stock
        if ($this->stock_quantity <= 0) {
            return 'Out of Stock';
        }

        // 2. Check for Low Stock (less than or equal to the minimum threshold)
        if ($this->stock_quantity <= $this->min_threshold) {
            return 'Low Stock';
        }

        // 3. Otherwise, it is Available
        return 'Available';
    }


   
}
