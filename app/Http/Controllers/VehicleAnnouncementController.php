<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleAnnouncement\IndexVehicleAnnouncementRequest;
use App\Http\Requests\VehicleAnnouncement\StoreVehicleAnnouncementRequest;
use App\Http\Requests\VehicleAnnouncement\UpdateVehicleAnnouncementRequest;
use App\Http\Resources\VehicleAnnouncementResource;
use App\Models\VehicleAnnouncement;
use App\Services\VehicleAnnouncement\DestroyVehicleAnnouncementService;
use App\Services\VehicleAnnouncement\IndexVehicleAnnouncementService;
use App\Services\VehicleAnnouncement\StoreVehicleAnnouncementService;
use App\Services\VehicleAnnouncement\UpdateVehicleAnnouncementService;

class VehicleAnnouncementController extends Controller
{
    public function index(
        IndexVehicleAnnouncementRequest $request,
        IndexVehicleAnnouncementService $service
    )
    {
        $data = $request->validated();
        $vehicleAnnouncements = $service->run($data);

        return VehicleAnnouncementResource::collection($vehicleAnnouncements);
    }

    public function store(
        StoreVehicleAnnouncementRequest $request,
        StoreVehicleAnnouncementService $service
    )
    {
        $data = $request->validated();
        $vehicleAnnouncement = $service->run($data);

        return response()->json(new VehicleAnnouncementResource($vehicleAnnouncement),201);
    }

    public function update(
        UpdateVehicleAnnouncementRequest $request,
        UpdateVehicleAnnouncementService $service,
        VehicleAnnouncement $vehicleAnnouncement
    )
    {
        $data = $request->validated();
        $vehicleAnnouncement = $service->run($vehicleAnnouncement, $data);

        return response()->json(new VehicleAnnouncementResource($vehicleAnnouncement), 200);
    }

    public function destroy(
        DestroyVehicleAnnouncementService $service,
        VehicleAnnouncement $vehicleAnnouncement
    )
    {
        $response = $service->run($vehicleAnnouncement);

        return response()->json($response);
    }
}
