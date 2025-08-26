<?php

namespace App\Services\Vehicle;

class DestroyVehicleService
{
    public function run($vehicle)
    {
        return $vehicle->delete();
    }
}
