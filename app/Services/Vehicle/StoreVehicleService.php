<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;

class StoreVehicleService
{
    private Vehicle $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function run(array $data)
    {
        return $this->vehicle->create($data);
    }
}
