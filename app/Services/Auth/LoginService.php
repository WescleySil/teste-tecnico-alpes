<?php

namespace App\Services\Auth;

use App\Models\User;

class LoginService
{
    public function run(array $data): array
    {
        $user = User::where('username', $data['login'])->orWhere('email', $data['login'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }
}
