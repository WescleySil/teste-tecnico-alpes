<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = $this->route('user')->id ?? null;

        return [
            'name' => ['sometimes', 'nullable', 'string'],
            'username' => ['sometimes', 'nullable', 'string', 'unique:users,username,'.$userId],
            'email' => ['sometimes', 'nullable', 'email', 'unique:users,email,'.$userId],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
        ];
    }
}
