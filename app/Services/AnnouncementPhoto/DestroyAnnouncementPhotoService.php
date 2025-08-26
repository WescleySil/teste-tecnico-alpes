<?php

namespace App\Services\AnnouncementPhoto;

use App\Models\AnnouncementPhoto;
use Illuminate\Support\Facades\DB;

class DestroyAnnouncementPhotoService
{
    private AnnouncementPhoto $announcementPhotoModel;

    public function __construct(AnnouncementPhoto $announcementPhotoModel)
    {
        $this->announcementPhotoModel = $announcementPhotoModel;
    }

    public function run($announcementPhoto): array
    {
        DB::transaction(function () use ($announcementPhoto) {
            $vehicleAnnouncementId = $announcementPhoto->vehicle_announcement_id;
            $deletedPosition = $announcementPhoto->position;

            $announcementPhoto->delete();

            $photosToReorder = $this->announcementPhotoModel->query()
                ->where('vehicle_announcement_id', $vehicleAnnouncementId)
                ->where('position', '>', $deletedPosition)
                ->orderBy('position', 'asc')
                ->get();

            foreach ($photosToReorder as $photo) {
                $photo->update(['position' => $photo->position - 1]);
            }
        });

        return ['message' => 'Foto do anúncio deletada e posições reordenadas com sucesso.'];
    }
}
