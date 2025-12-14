<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Viewing extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_service_id',
        'viewing_date',
        'location',
        'address',
        'viewing_type',
        'special_requests',
        'status',
    ];

    protected $casts = [
        'viewing_date' => 'date',
    ];

   
    public function bookService()
    {
        return $this->belongsTo(BookService::class, 'book_service_id');
    }

    /**
     * Check if viewing is upcoming
     */
    public function isUpcoming()
    {
        return $this->status === 'Scheduled' && 
               $this->viewing_date >= Carbon::today();
    }

    /**
     * Check if viewing is past
     */
    public function isPast()
    {
        return $this->viewing_date < Carbon::today();
    }

    /**
     * Check if viewing is today
     */
    public function isToday()
    {
        return $this->viewing_date->isToday();
    }

    /**
     * Check if viewing can be edited
     */
    public function canEdit()
    {
        return $this->status === 'Scheduled' && 
               $this->viewing_date >= Carbon::today();
    }

    /**
     * Check if viewing can be cancelled
     */
    public function canCancel()
    {
        return !in_array($this->status, ['Cancelled', 'Completed']);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'Scheduled' => 'badge-progress',
            'In Progress' => 'badge-warning',
            'Completed' => 'badge-success',
            'Cancelled' => 'badge-danger',
            default => 'badge-progress',
        };
    }

    /**
     * Get viewing type badge class
     */
    public function getViewingTypeBadgeClass()
    {
        return match($this->viewing_type) {
            'Public' => 'badge-success',
            'Private' => 'badge-progress',
            'Family Only' => 'badge-warning',
            default => 'badge-progress',
        };
    }

    /**
     * Get formatted viewing date
     */
    public function getFormattedDateAttribute()
    {
        return $this->viewing_date->format('F d, Y');
    }

    /**
     * Get days until viewing
     */
    public function getDaysUntilAttribute()
    {
        if ($this->viewing_date < Carbon::today()) {
            return null;
        }
        
        $days = Carbon::today()->diffInDays($this->viewing_date);
        return $days;
    }
}