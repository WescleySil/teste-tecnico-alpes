<?php

namespace App\Services\VehicleAnnouncement;

use App\Models\VehicleAnnouncement;

class DestroyVehicleAnnouncementService
{
    public function run(VehicleAnnouncement $vehicleAnnouncement): bool
    {
        return $vehicleAnnouncement->delete();
    }
}
