<?php

namespace App\Http\Requests\VehicleAnnouncement;

use Illuminate\Foundation\Http\FormRequest;

class IndexVehicleAnnouncementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_by.column' => ['sometimes', 'string'],
            'order_by.direction' => ['sometimes', 'in:asc,desc'],
            'per_page' => ['sometimes' ,'integer']
        ];
    }
}
