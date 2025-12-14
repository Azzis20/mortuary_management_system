<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    //
    protected $fillable = [
        'bill_id',
        'client_id',
        'amount',  
        'payment_date',
        'processed_by',
        
    ];
    protected $casts = [
        'payment_date' => 'datetime', 
        
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class,'client_id');
    }
    
        public function processed_by(): BelongsTo
    {
        return $this->belongsTo(User::class,'processed_by');
    }
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }





    
}
