<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingItem extends Model
{
    //
    protected $fillable = [
        'book_service_id',
        'inventory_id',
        'item_name',
        'quantity', 
        'record_by', 

    ];

    public function booking(): BelongsTo
    {
        
        return $this->belongsTo(BookService::class);

       
    }  

    public function inventory(): BelongsTo
    {
        
        return $this->belongsTo(Inventory::class );

       
    }  
    public function recordBy(): BelongsTo
    {
        
        return $this->belongsTo(User::class, 'recorded_by' );

       
    }  



}
