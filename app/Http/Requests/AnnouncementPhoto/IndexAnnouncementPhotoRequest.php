<?php

namespace App\Http\Requests\AnnouncementPhoto;

use Illuminate\Foundation\Http\FormRequest;

class IndexAnnouncementPhotoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_by.column' => ['sometimes', 'string'],
            'order_by.direction' => ['sometimes', 'in:asc,desc'],
            'per_page' => ['sometimes', 'integer'],
        ];
    }
}
