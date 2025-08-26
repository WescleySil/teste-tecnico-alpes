<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('db:wipe');
    Artisan::call('migrate');
    (new UserSeeder())->run();
});

describe("Teste de CRUD para Usuarios", function () {
    test('an user can create a new user', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);

        $userData = [
            'name' => 'New User',
            'username' => 'newuser',
            'email' => 'new@example.com',
            'password' => 'password123',
        ];

        $this->postJson('/api/user', $userData)
            ->assertStatus(201)
            ->assertJsonFragment(['email' => 'new@example.com']);

        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email' => 'new@example.com',
        ]);
    });

    test('a user can register', function () {
        $userData = [
            'name' => 'Another User',
            'username' => 'anotheruser',
            'email' => 'another@example.com',
            'password' => 'password123',
        ];

        $this->postJson('/api/user', $userData)->assertCreated();
    });

    test('user creation fails with validation errors', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);

        $this->postJson('/api/user', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'username', 'email', 'password']);
    });

    test('an authenticated user can list users', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);

        $this->getJson('/api/user')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'username', 'email']
                ]
            ]);
    });

    test('a user can be updated', function () {
        $userToUpdate = User::all()->last();
        $user = User::all()->first();
        Sanctum::actingAs($user);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $this->putJson('/api/user/' . $userToUpdate->id, $updateData)
            ->assertStatus(200)
            ->assertJsonFragment(['email' => 'updated@example.com']);

        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    });

    test('a user can be deleted', function () {
        $userToDelete = User::factory()->create();
        $user = User::all()->first();
        Sanctum::actingAs($user);

        $this->deleteJson('/api/user/' . $userToDelete->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id,
        ]);
    });
});
