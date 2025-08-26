<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => 'Car',
            'brand' => 'Test Brand',
            'model' => 'Test Model',
            'version' => '1.0 Test',
            'year' => [
                'model' => '2023',
                'build' => '2022',
            ],
            'doors' => 4,
            'board' => 'TST-1234',
            'chassi' => '1234567890ABCDEFG',
            'transmission' => 'Automatic',
            'color' => 'Black',
            'fuel' => 'Gasoline',
            'category' => 'Test Category',
        ];
    }
}
