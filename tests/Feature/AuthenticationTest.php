<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('db:wipe');
    Artisan::call('migrate');
    (new UserSeeder())->run();
});

describe("Teste de autenticação", function () {
    test('user can login with correct credentials', function () {
        $this->postJson('/api/login', [
            'login' => 'admin',
            'password' => '12345678',
        ])
            ->assertOk()
            ->assertJsonStructure(['token']);

        $this->assertAuthenticated();
    });

    test('user can login with email', function () {
        $this->postJson('/api/login', [
            'login' => 'admin@admin.com',
            'password' => '12345678',
        ])
            ->assertOk()
            ->assertJsonStructure(['token']);

        $this->assertAuthenticated();
    });

    test('login fails for non-existent user', function () {
        $this->postJson('/api/login', [
            'login' => 'nonexistent',
            'password' => 'password',
        ])->assertStatus(422);

        $this->assertGuest();
    });

    test('an authenticated user can logout', function () {
        $admin = User::first();
        $token = $admin->createToken('test-token')->plainTextToken;

        $this->withToken($token)->postJson('/api/logout')
            ->assertOk()
            ->assertJson(['message' => 'Logout realizado com sucesso.']);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $admin->id,
            'name' => 'test-token'
        ]);
    });
});
