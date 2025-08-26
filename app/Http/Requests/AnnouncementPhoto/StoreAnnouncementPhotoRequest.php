<?php

namespace App\Http\Requests\AnnouncementPhoto;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementPhotoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_announcement_id' => ['required', 'exists:vehicle_announcements,id'],
            'photos' => ['required', 'array'],
            'photos.*.photo_url' => ['required', 'string', 'url'],
            'photos.*.position' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'exists' => 'O :attribute informado não existe.',
            'array' => 'O campo :attribute deve ser um array.',
            'photos.*.photo_url.required' => 'A URL da foto é obrigatória.',
            'photos.*.photo_url.url' => 'A URL da foto deve ser uma URL válida.',
            'photos.*.position.required' => 'A posição da foto é obrigatória.',
            'photos.*.position.integer' => 'A posição da foto deve ser um número inteiro.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $photos = $this->input('photos', []);
            if (empty($photos)) {
                return;
            }

            $positions = array_column($photos, 'position');
            if (count($positions) !== count(array_unique($positions))) {
                $validator->errors()->add('photos', 'Não é permitido enviar posições duplicadas para as fotos.');
            }
        });
    }
}
