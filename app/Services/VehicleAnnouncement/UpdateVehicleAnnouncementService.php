<?php

namespace App\Services\VehicleAnnouncement;

use App\Models\VehicleAnnouncement;

class UpdateVehicleAnnouncementService
{
    public function run(VehicleAnnouncement $vehicleAnnouncement, array $data): VehicleAnnouncement
    {
        $vehicleAnnouncement->update($data);
        return $vehicleAnnouncement;
    }
}
