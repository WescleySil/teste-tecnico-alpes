<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['sometimes' ,'string', 'min:3'],
            'brand' => ['sometimes', 'string', 'min:3'],
            'model' => ['sometimes', 'string', 'min:3'],
            'version' => ['sometimes', 'string', 'min:3'],
            'year' => ['sometimes', 'array'],
            'year.model' => ['sometimes_with:year.build', 'string', 'max:4'],
            'year.build' => ['sometimes_with:year.model', 'string', 'max:4'],
            'doors' => ['sometimes', 'integer', 'min:2'],
            'board' => ['sometimes', 'string', 'min:7', 'max:7'],
            'chassi' => ['sometimes', 'string', 'min:17', 'max:17'],
            'transmission' => ['sometimes', 'string', 'min:3'],
            'color' => ['sometimes', 'string', 'min:3'],
            'fuel' => ['sometimes', 'string', 'min:3'],
            'category' => ['sometimes', 'string', 'min:3'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute tem que ter no minimo :min caracteres',
            'max' => 'O campo :attribute so pode ter no maximo :max caracteres',
            'integer' => 'O campo :attribute so aceita numeros'
        ];
    }
}
