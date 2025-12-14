<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Hasmany;

class Deceased extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'date_of_birth',
        'date_of_death',
        'cause_of_death',
        // 'assignedStaff',
        'document',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_death' => 'date',
    ];

    /**
     * Get the user (e.g., family member) who registered this deceased person.
     *
     * This links the 'user_id' in the 'deceaseds' table
     * to the 'id' in the 'users' table.
     */

    // public function assignedStaff()
    // {
    //     // Assuming 'user_id' in BookService refers to the assigned staff
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    
    public function bookServices(): HasMany
    {
        return $this->hasMany(BookService::class);
        
    }
    
    
    public function nextOfKins(): HasOne
    {
        return $this->hasOne(NextOfKin::class);
    }
}