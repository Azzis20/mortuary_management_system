<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'deceased_id',
        'name',
        'relationship',
        'email',
        'contact_number',
        'address',
    ];

    public function Deceased(): BelongsTo   
    {
        return $this->belongsTo(Deceased::class);
    }

}
