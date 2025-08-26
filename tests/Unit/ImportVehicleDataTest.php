<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Testes do Comando de Importação de Veículos', function () {

    it('deve importar os dados do veículo com sucesso a partir da API', function () {
        Http::fake([
            'https://hub.alpes.one/api/v1/integrator/export/1902' => Http::response([
                [
                    'id' => 123,
                    'type' => 'car',
                    'brand' => 'Test Brand',
                    'model' => 'Test Model',
                    'version' => '1.0',
                    'year' => 2023,
                    'doors' => 4,
                    'board' => 'ABC1234',
                    'chassi' => '123456789',
                    'transmission' => 'automatic',
                    'color' => 'black',
                    'fuel' => 'gasoline',
                    'category' => 'suv',
                    'description' => 'A test vehicle.',
                    'price' => 80000.00,
                    'old_price' => 85000.00,
                    'sold' => false,
                    'url_car' => 'http://example.com/car/123',
                    'optionals' => ['air conditioning', 'power steering'],
                    'fotos' => [
                        'http://example.com/photo1.jpg',
                        'http://example.com/photo2.jpg',
                    ],
                    'created' => now()->toDateTimeString(),
                    'updated' => now()->toDateTimeString(),
                ],
            ], 200),
        ]);

        $this->artisan('vehicle:import-data')
            ->expectsOutput('Dados importados com sucesso!')
            ->assertExitCode(0);

        $this->assertDatabaseHas('vehicles', [
            'external_id' => 123,
            'brand' => 'Test Brand',
            'model' => 'Test Model',
        ]);

        $this->assertDatabaseHas('vehicle_announcements', [
            'price' => 80000.00,
            'description' => 'A test vehicle.',
        ]);

        $this->assertDatabaseHas('announcement_photos', [
            'photo_url' => 'http://example.com/photo1.jpg',
            'position' => 1,
        ]);

        $this->assertDatabaseHas('announcement_photos', [
            'photo_url' => 'http://example.com/photo2.jpg',
            'position' => 2,
        ]);
    });

    it('deve lidar com uma falha na API', function () {
        Http::fake([
            'https://hub.alpes.one/api/v1/integrator/export/1902' => Http::response(null, 500),
        ]);

        $this->artisan('vehicle:import-data')
            ->expectsOutputToContain('Erro ao importar os dados: HTTP request returned status code 500')
            ->assertExitCode(0);

        $this->assertDatabaseCount('vehicles', 0);
        $this->assertDatabaseCount('vehicle_announcements', 0);
        $this->assertDatabaseCount('announcement_photos', 0);
    });
});
