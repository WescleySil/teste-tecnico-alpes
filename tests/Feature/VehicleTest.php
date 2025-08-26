<?php

use App\Models\User;
use App\Models\Vehicle;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Artisan::call('db:wipe');
    Artisan::call('migrate');
    (new UserSeeder())->run();
});

describe('Testes de CRUD para a API de Veículos', function () {

    it('deve listar os veículos com paginação e ordenação', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        Vehicle::factory()->create(['brand' => 'Ford']);
        Vehicle::factory()->create(['brand' => 'Chevrolet']);
        Vehicle::factory()->create(['brand' => 'Audi']);

        $response = $this->getJson('/api/vehicles?per_page=2&order_by[column]=brand&order_by[direction]=asc');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(['data', 'links', 'meta']);

        $brands = $response->json('data.*.brand');
        expect($brands)->toBe(['Audi', 'Chevrolet']);
    });

    it('deve criar um novo veículo', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $payload = [
            'type' => 'Car',
            'brand' => 'Volkswagen',
            'model' => 'Golf',
            'version' => 'GTI',
            'year' => ['model' => '2022', 'build' => '2021'],
            'doors' => 4,
            'board' => 'GTI2022',
            'transmission' => 'Automatic',
            'color' => 'Red',
            'fuel' => 'Gasoline',
            'category' => 'Hatchback',
        ];

        $response = $this->postJson('/api/vehicles', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'brand', 'model', 'version'])
            ->assertJsonFragment(['brand' => 'Volkswagen']);

        $this->assertDatabaseHas('vehicles', ['board' => 'GTI2022']);
    });

    it('deve atualizar um veículo existente', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $vehicle = Vehicle::factory()->create(['color' => 'Red']);

        $payload = [
            'color' => 'Blue',
            'version' => '2.0 Turbo',
        ];

        $response = $this->putJson("/api/vehicles/{$vehicle->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['color' => 'Blue']);

        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->id,
            'color' => 'Blue',
            'version' => '2.0 Turbo',
        ]);
    });

    it('deve deletar um veículo', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $vehicle = Vehicle::factory()->create();

        $response = $this->deleteJson("/api/vehicles/{$vehicle->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('vehicles', ['id' => $vehicle->id]);
    });

});
