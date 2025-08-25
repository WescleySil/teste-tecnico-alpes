<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleAnnouncement extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'vehicle_id',
        'description',
        'price',
        'old_price',
        'sold',
        'url_car',
        'optionals',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'sold' => 'boolean',
        'optionals' => 'array',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(AnnouncementPhoto::class, 'vehicle_announcement_id');
    }
}
