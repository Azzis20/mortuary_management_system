<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageItem extends Model
{
    //

    protected $fillable = [
        'package_id',
        'service_name',
        'description'
    ];

    public function Package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
