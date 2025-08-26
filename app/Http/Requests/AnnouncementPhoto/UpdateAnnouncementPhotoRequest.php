<?php

namespace App\Http\Requests\AnnouncementPhoto;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementPhotoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'photo_url' => ['sometimes', 'string', 'url'],
            'position' => ['sometimes', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'url' => 'O campo :attribute deve ser uma URL válida.',
            'string' => 'O campo :attribute deve ser um texto.',
            'integer' => 'O campo :attribute só aceita números.',
        ];
    }
}
