<?php

namespace App\Services\VehicleAnnouncement;

use App\Models\VehicleAnnouncement;

class StoreVehicleAnnouncementService
{
    private VehicleAnnouncement $vehicleAnnouncement;

    public function __construct(VehicleAnnouncement $vehicleAnnouncement)
    {
        $this->vehicleAnnouncement = $vehicleAnnouncement;
    }

    public function run(array $data): VehicleAnnouncement
    {
        return $this->vehicleAnnouncement->create($data);
    }
}
