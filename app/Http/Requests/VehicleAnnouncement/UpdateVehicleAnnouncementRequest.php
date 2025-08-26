<?php

namespace App\Http\Requests\VehicleAnnouncement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleAnnouncementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_id' => ['sometimes', 'exists:vehicles,id,deleted_at,NULL'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric'],
            'old_price' => ['sometimes', 'nullable', 'numeric'],
            'sold' => ['sometimes', 'nullable', 'boolean'],
            'url_car' => ['sometimes', 'string'],
            'optionals' => ['sometimes', 'nullable', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'numeric' => 'O campo :attribute so aceita numeros',
            'boolean' => 'O campo :attribute so aceita true ou false',
            'exists' => 'O :attribute informado não existe',
        ];
    }
}
