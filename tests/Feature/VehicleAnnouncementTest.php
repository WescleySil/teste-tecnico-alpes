<?php

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleAnnouncement;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Artisan::call('db:wipe');
    Artisan::call('migrate');
    (new UserSeeder())->run();
});

describe('Testes de CRUD de Anúncio de Veículo', function () {

    it('deve ser capaz de criar um anúncio de veículo', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $vehicle = Vehicle::factory()->create();

        $payload = [
            'vehicle_id' => $vehicle->id,
            'description' => 'A static test description.',
            'price' => 75000.50,
            'url_car' => 'http://my-car-url.com/123',
        ];

        $response = $this->postJson('/api/vehicle-announcements', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'description',
                'price',
                'url_car',
            ]);

        $this->assertDatabaseHas('vehicle_announcements', [
            'vehicle_id' => $vehicle->id,
            'price' => 75000.50,
        ]);
    });

    it('deve ser capaz de listar anúncios de veículos com paginação e ordenação', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        VehicleAnnouncement::factory()->count(20)->create();

        $response = $this->getJson('/api/vehicle-announcements?per_page=5&order_by[column]=price&order_by[direction]=desc');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure(['data', 'links', 'meta']);

        $prices = collect($response->json('data'))->pluck('price')->toArray();
        $sortedPrices = $prices;
        rsort($sortedPrices);

        expect($prices)->toEqual($sortedPrices);
    });

    it('deve ser capaz de atualizar um anúncio de veículo', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $announcement = VehicleAnnouncement::factory()->create(['price' => 50000.00]);

        $payload = [
            'price' => 52500.00,
            'description' => 'Descrição atualizada.',
        ];

        $response = $this->putJson("/api/vehicle-announcements/{$announcement->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['price' => '52500.00']);

        $this->assertDatabaseHas('vehicle_announcements', [
            'id' => $announcement->id,
            'price' => 52500.00,
        ]);
    });

    it('deve ser capaz de deletar um anúncio de veículo', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $announcement = VehicleAnnouncement::factory()->create();

        $response = $this->deleteJson("/api/vehicle-announcements/{$announcement->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('vehicle_announcements', [
            'id' => $announcement->id,
        ]);
    });

});
