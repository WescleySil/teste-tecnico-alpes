<?php

namespace App\Services\AnnouncementPhoto;

use App\Models\AnnouncementPhoto;

class IndexAnnouncementPhotoService
{
    public function run(array $data)
    {
        $orderByColumn = $data['order_by']['column'] ?? 'id';
        $orderByDirection = $data['order_by']['direction'] ?? 'asc';
        $perPage = $data['per_page'] ?? 10;

        $announcementPhotos = AnnouncementPhoto::query()
            ->orderBy($orderByColumn, $orderByDirection)
            ->paginate($perPage);

        return $announcementPhotos;
    }
}
