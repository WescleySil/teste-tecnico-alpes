<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;

class UpdateVehicleService
{
    public function run(Vehicle $vehicle, array $data)
    {
        $vehicle->update($data);

        return $vehicle;
    }
}
