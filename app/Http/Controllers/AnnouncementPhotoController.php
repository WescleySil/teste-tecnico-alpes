<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementPhoto\IndexAnnouncementPhotoRequest;
use App\Http\Requests\AnnouncementPhoto\StoreAnnouncementPhotoRequest;
use App\Http\Requests\AnnouncementPhoto\UpdateAnnouncementPhotoRequest;
use App\Http\Resources\AnnouncementPhotoResource;
use App\Models\AnnouncementPhoto;
use App\Services\AnnouncementPhoto\DestroyAnnouncementPhotoService;
use App\Services\AnnouncementPhoto\IndexAnnouncementPhotoService;
use App\Services\AnnouncementPhoto\StoreAnnouncementPhotoService;
use App\Services\AnnouncementPhoto\UpdateAnnouncementPhotoService;

class AnnouncementPhotoController extends Controller
{
    public function index(
        IndexAnnouncementPhotoRequest $request,
        IndexAnnouncementPhotoService $service
    )
    {
        $data = $request->validated();
        $announcementPhotos = $service->run($data);

        return AnnouncementPhotoResource::collection($announcementPhotos);
    }

    public function store(
        StoreAnnouncementPhotoRequest $request,
        StoreAnnouncementPhotoService $service
    )
    {
        $data = $request->validated();
        $announcementPhotos = $service->run($data);

        return response()->json(AnnouncementPhotoResource::collection($announcementPhotos), 201);
    }

    public function update(
        UpdateAnnouncementPhotoRequest $request,
        UpdateAnnouncementPhotoService $service,
        AnnouncementPhoto $announcementPhoto
    )
    {
        $data = $request->validated();
        $announcementPhoto = $service->run($announcementPhoto, $data);

        return response()->json(new AnnouncementPhotoResource($announcementPhoto), 200);
    }

    public function destroy(
        DestroyAnnouncementPhotoService $service,
        AnnouncementPhoto $announcementPhoto
    )
    {
        $response = $service->run($announcementPhoto);

        return response()->json($response);
    }
}
