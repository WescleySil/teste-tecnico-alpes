<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class IndexVehicleRequest extends FormRequest
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
