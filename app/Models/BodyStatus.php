<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BodyStatus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'deceased_id',
        'status',
        'location',
        // 'staff_id', // Add this if you uncomment the migration line
    ];

    /**
     * Get the deceased person this status log belongs to.
     *
     * This links the 'deceased_id' in this 'body_statuses' table
     * to the 'id' in the 'deceaseds' table.
     */
    public function deceased(): BelongsTo
    {
        return $this->belongsTo(Deceased::class);
    }
}
