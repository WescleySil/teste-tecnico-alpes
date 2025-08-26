<?php

namespace App\Services\AnnouncementPhoto;

use App\Models\AnnouncementPhoto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StoreAnnouncementPhotoService
{
    private AnnouncementPhoto $announcementPhoto;

    public function __construct(AnnouncementPhoto $announcementPhoto)
    {
        $this->announcementPhoto = $announcementPhoto;
    }

    public function run(array $data): Collection
    {
        $createdPhotos = collect();

        DB::transaction(function () use ($data, &$createdPhotos) {
            $vehicleAnnouncementId = $data['vehicle_announcement_id'];
            foreach ($data['photos'] as $photoData) {
                $photo = $this->announcementPhoto->create([
                    'vehicle_announcement_id' => $vehicleAnnouncementId,
                    'photo_url' => $photoData['photo_url'],
                    'position' => $photoData['position'],
                ]);
                $createdPhotos->push($photo);
            }
        });

        return $createdPhotos;
    }
}
