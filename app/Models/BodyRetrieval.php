<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BodyRetrieval extends Model
{
    //
    protected $fillable = [
        'book_service_id',
        'location',
        'address',
        'retrieval_schedule',
    ];



    public function bookservice(): BelongsTo

    {
        return $this->belongsTo(BookService::class); //'booking_id'
    }

    
}
