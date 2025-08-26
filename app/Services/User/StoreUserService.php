<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreUserService
{
    public function run(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }
}
