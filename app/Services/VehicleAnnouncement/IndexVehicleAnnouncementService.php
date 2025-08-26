<?php

namespace App\Services\VehicleAnnouncement;

use App\Models\VehicleAnnouncement;

class IndexVehicleAnnouncementService
{
    public function run(array $data)
    {
        $orderByColumn = $data['order_by']['column'] ?? 'id';
        $orderByDirection = $data['order_by']['direction'] ?? 'asc';
        $perPage = $data['per_page'] ?? 10;

        $vehicleAnnouncements = VehicleAnnouncement::query()
            ->orderBy($orderByColumn, $orderByDirection)
            ->paginate($perPage);

        return $vehicleAnnouncements;
    }
}
