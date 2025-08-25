<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnouncementPhoto extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'vehicle_announcement_id',
        'photo_url',
        'position',
    ];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(VehicleAnnouncement::class, 'vehicle_announcement_id');
    }
}
