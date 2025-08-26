<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleAnnouncementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'description' => 'A static test description.',
            'price' => 50000.00,
            'old_price' => null,
            'sold' => false,
            'url_car' => 'http://example.com/car-announcement',
            'optionals' => ['Air Conditioning', 'Power Steering'],
        ];
    }
}
