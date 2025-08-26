<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'external_id',
        'type',
        'brand',
        'model',
        'version',
        'year',
        'doors',
        'board',
        'chassi',
        'transmission',
        'color',
        'fuel',
        'category',
    ];

    protected $casts = [
        'year' => 'array',
    ];

    public function announcements(): HasMany
    {
        return $this->hasMany(VehicleAnnouncement::class);
    }
}
