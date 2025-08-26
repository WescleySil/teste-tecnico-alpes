<?php

namespace App\Http\Requests\VehicleAnnouncement;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleAnnouncementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'exists:vehicles,id,deleted_at,NULL'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'old_price' => ['nullable', 'numeric'],
            'sold' => ['nullable', 'boolean'],
            'url_car' => ['required', 'string'],
            'optionals' => ['nullable', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'numeric' => 'O campo :attribute so aceita numeros',
            'boolean' => 'O campo :attribute so aceita true ou false',
            'array' => 'O campo :attribute deve ser um array',
            'exists' => 'O :attribute informado não existe',
        ];
    }
}
