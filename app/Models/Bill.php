<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    //
    protected $fillable = [
       
        'book_service_id',  // 'booking_id',
        'total_amount', //'total_amount',
        'paid_amount',
        'balance_amount',
        'payment_status',
        'due_date' //to be ereased later....
    ];



    // Relationship to BookService
    public function bookService(): BelongsTo
    {
        // return $this->belongsTo(BookService::class,'booking_id');
        return $this->belongsTo(BookService::class);
    }
    public function payment(): HasMany
    {
        // return $this->belongsTo(BookService::class,'booking_id');
        return $this->hasMany(Payment::class);
    }
}
