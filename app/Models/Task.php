<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Task extends Model
{
    //
     protected $fillable = [
        'book_service_id', //booking_id
        'staff_id',
        'task_type',
        'status',
        'notes',
       
    ];

   

     public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id' );
    }
     public function booking(): BelongsTo
    {
        return $this->belongsTo(BookService::class); //booking_id
    }


}
