<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\IndexVehicleRequest;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Services\Vehicle\DestroyVehicleService;
use App\Services\Vehicle\IndexVehicleService;
use App\Services\Vehicle\StoreVehicleService;
use App\Services\Vehicle\UpdateVehicleService;

class VehicleController extends Controller
{
    public function index(
        IndexVehicleRequest $request,
        IndexVehicleService $service
    )
    {
        $data = $request->validated();
        $vehicles = $service->run($data);

        return VehicleResource::collection($vehicles);
    }

    public function store(
        StoreVehicleRequest $request,
        StoreVehicleService $service
    )
    {
        $data = $request->validated();
        $vehicle = $service->run($data);

        return response()->json(new VehicleResource($vehicle),201);
    }

    public function update(
        UpdateVehicleRequest $request,
        UpdateVehicleService $service,
        Vehicle $vehicle
    )
    {
        $data = $request->validated();
        $vehicle = $service->run($vehicle, $data);

        return response()->json(new VehicleResource($vehicle), 200);
    }

    public function destroy(
        DestroyVehicleService $service,
        Vehicle $vehicle
    )
    {
        $response = $service->run($vehicle);

        return response()->json($response);
    }
}
