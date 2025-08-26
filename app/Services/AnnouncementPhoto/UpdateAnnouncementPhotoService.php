<?php

namespace App\Services\AnnouncementPhoto;

use App\Models\AnnouncementPhoto;
use Illuminate\Support\Facades\DB;

class UpdateAnnouncementPhotoService
{
    private AnnouncementPhoto $announcementPhotoModel;

    public function __construct(AnnouncementPhoto $announcementPhotoModel)
    {
        $this->announcementPhotoModel = $announcementPhotoModel;
    }

    public function run($announcementPhoto, array $data): AnnouncementPhoto
    {
        if (! isset($data['position']) || $announcementPhoto->position === $data['position']) {
            $announcementPhoto->update($data);

            return $announcementPhoto->fresh();
        }

        DB::transaction(function () use ($announcementPhoto, $data) {
            $newPosition = $data['position'];
            $oldPosition = $announcementPhoto->position;

            $otherPhoto = $this->announcementPhotoModel->query()
                ->where('vehicle_announcement_id', $announcementPhoto->vehicle_announcement_id)
                ->where('position', $newPosition)
                ->first();

            if ($otherPhoto) {
                $otherPhoto->update(['position' => $oldPosition]);
            }

            $announcementPhoto->update($data);
        });

        return $announcementPhoto->fresh();
    }
}
