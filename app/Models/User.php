<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Define allowed account types as a constant
     * This makes it easy to reference throughout your app
     */
    public const ACCOUNT_TYPES = [
        'client',
        'admin',
        'driver',
        'staff',
        'embalmer',
        // 'superadmin'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'accountType',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Boot method to add validation
     * This prevents invalid account types from being saved
     */
    protected static function booted()
    {
        static::saving(function ($user) {
            if (!in_array($user->accountType, self::ACCOUNT_TYPES)) {
                throw new \InvalidArgumentException(
                    "Invalid account type: {$user->accountType}. Allowed types: " . 
                    implode(', ', self::ACCOUNT_TYPES)
                );
            }
        });
    }

    // ==========================================
    // Helper methods to check account types
    // ==========================================

    public function isClient(): bool
    {
        return $this->accountType === 'client';
    }

    public function isAdmin(): bool
    {
        return $this->accountType === 'admin';
    }

    // public function hasAdminAccess(): bool
    // {
    //     return $this->accountType === 'superadmin';
    // }

    // ADD NEW HELPER METHODS for other roles
    public function isDriver(): bool
    {
        return $this->accountType === 'driver';
    }

    public function isStaff(): bool
    {
        return $this->accountType === 'staff';
    }

    public function isEmbalmer(): bool
    {
        return $this->accountType === 'embalmer';
    }

    /**
     * Check if user has any of the specified roles
     */
    public function hasRole(string ...$roles): bool
    {
        return in_array($this->accountType, $roles);
    }




    // ==========================================
    // Relationships
    // ==========================================

    /**
     * Admin who created packages
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'created_by');
    }

    /**
     * Staff who is assigned to tasks
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'staff_id'); //
    }

    /**
     * Client bookings
     */
    public function bookServices(): HasMany
    {
        return $this->hasMany(BookService::class, 'client_id');
    }

    /**
     * Bookings approved by admin
     */
    public function approvedBookings(): HasMany // Renamed for clarity
    {
        return $this->hasMany(BookService::class, 'approved_by');
    }

    /**
     * User profile (one-to-one)
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Deceased persons registered by this user
     */
    public function deceaseds(): HasMany
    {
        return $this->hasMany(Deceased::class);
    }

    /**
     * Payments made by client
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'client_id');
    }

    /**
     * Payments processed by staff
     */
    public function processedPayments(): HasMany // Renamed for clarity
    {
        return $this->hasMany(Payment::class, 'processed_by');
    }

    /**
     * Booking items recorded by user
     */
    public function bookingItems(): HasMany // Renamed to plural for consistency
    {
        return $this->hasMany(BookingItem::class, 'recorded_by');
    }
}