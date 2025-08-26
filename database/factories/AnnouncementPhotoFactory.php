<?php

namespace Database\Factories;

use App\Models\VehicleAnnouncement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementPhotoFactory extends Factory
{
    private static int $sequence = 0;

    public function definition(): array
    {
        self::$sequence++;

        return [
            'vehicle_announcement_id' => VehicleAnnouncement::factory(),
            'photo_url' => 'http://example.com/photo' . self::$sequence . '.jpg',
            'position' => self::$sequence,
        ];
    }
}
