<?php

namespace App\Services\User;

use App\Models\User;

class IndexUserService
{
    public function run(array $data = [])
    {
        $name = $data['filters']['name'] ?? null;
        $username = $data['filters']['username'] ?? null;
        $email = $data['filters']['email'] ?? null;
        $perPage = $data['filters']['per_page'] ?? 10;

        $query = User::query()
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
            $query->when($username, function ($query) use ($username) {
                $query->where('username', 'like', '%' . $username . '%');
            });
            $query->when($email, function ($query) use ($email) {
                $query->where('email', 'like', '%' . $email . '%');
            });

        return $query->paginate($perPage);
    }
}
