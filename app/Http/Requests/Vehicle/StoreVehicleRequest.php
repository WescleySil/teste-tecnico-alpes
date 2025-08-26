<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required' ,'string', 'min:3'],
            'brand' => ['required', 'string', 'min:3'],
            'model' => ['required', 'string', 'min:3'],
            'version' => ['required', 'string', 'min:3'],
            'year' => ['required', 'array'],
            'year.model' => ['required_with:year.build', 'string', 'max:4'],
            'year.build' => ['required_with:year.model', 'string', 'max:4'],
            'doors' => ['required', 'integer', 'min:2'],
            'board' => ['required', 'string', 'min:7', 'max:7'],
            'chassi' => ['sometimes', 'string', 'min:17', 'max:17'],
            'transmission' => ['required', 'string', 'min:3'],
            'color' => ['required', 'string', 'min:3'],
            'fuel' => ['required', 'string', 'min:3'],
            'category' => ['required', 'string', 'min:3'],
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
