<?php

namespace App\Services\AnnouncementPhoto;

use App\Models\AnnouncementPhoto;
use Illuminate\Support\Facades\DB;

class DestroyAnnouncementPhotoService
{
    public function run(AnnouncementPhoto $announcementPhoto): array
    {
        DB::transaction(function () use ($announcementPhoto) {
            $vehicleAnnouncementId = $announcementPhoto->vehicle_announcement_id;
            $deletedPosition = $announcementPhoto->position;

            $announcementPhoto->delete();

            $photosToReorder = AnnouncementPhoto::query()
                ->where('vehicle_announcement_id', $vehicleAnnouncementId)
                ->where('position', '>', $deletedPosition)
                ->orderBy('position', 'asc')
                ->get();

            foreach ($photosToReorder as $photo) {
                $photo->decrement('position');
            }
        });

        return ['message' => 'Foto do anúncio deletada e posições reordenadas com sucesso.'];
    }
}
