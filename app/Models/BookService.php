<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class BookService extends Model
{
    //
    protected $fillable = [
        'deceased_id', // 'client_id',
        'client_id',
        'package_id',
        'status', //'Pending', 'Confirmed', 'Dispatch','InCare','Viewing','Released','Declined'
        'approved_by', //aproave by staff admin? //nullable 
        'status_id'

    ];

    public function deceased(): BelongsTo
    {
        return $this->belongsTo(Deceased::class);
    }
    
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class,'client_id'); //client
    }

     public function approvedBy(): BelongsTo
    {
        
        return $this->belongsTo(User::class,'approved_by'); //fk to user table
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class); //package_id
    }

    public function booking_items(): HasMany
    {
        return $this->hasMany(BookingItem::class); //package_id
    }



    public function bodyRetrieval(): HasOne
    {   
        return $this->hasOne(BodyRetrieval::class); 
    }  

    public function viewing(): HasOne
    { 
        return $this->hasOne(Viewing::class);
    }  

    public function status(): HasOne
    {
        return $this->hasOne(Status::class );
    }  

    
    public function bill(): HasOne
    {
        return $this->hasOne(Bill::class);
    }
   
    public function tasks(): HasMany
    {
        
        return $this->hasMany(Task::class); //fk to user table
    }



}


