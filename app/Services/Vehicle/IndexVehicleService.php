<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;

class IndexVehicleService
{
    public function run (array $data)
    {
        $orderByColumn = $data['order_by']['column'] ?? 'id';
        $orderByDirection = $data['order_by']['direction'] ?? 'asc';

        $perPage = $data['per_page'] ?? 10;

        $vehicles = Vehicle::query()
            ->orderBy($orderByColumn, $orderByDirection)
            ->paginate($perPage);

        return $vehicles;
    }
}
