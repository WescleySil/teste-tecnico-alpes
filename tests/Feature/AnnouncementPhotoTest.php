<?php

use App\Models\AnnouncementPhoto;
use App\Models\User;
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

describe('Testes de CRUD para Fotos de Anúncio', function () {

    it('deve listar as fotos do anúncio com paginação e ordenação', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $announcement = VehicleAnnouncement::factory()->create();
        AnnouncementPhoto::factory()->create(['vehicle_announcement_id' => $announcement->id, 'position' => 2]);
        AnnouncementPhoto::factory()->create(['vehicle_announcement_id' => $announcement->id, 'position' => 3]);
        AnnouncementPhoto::factory()->create(['vehicle_announcement_id' => $announcement->id, 'position' => 1]);

        $response = $this->getJson('/api/announcement-photos?per_page=2&order_by[column]=position&order_by[direction]=desc');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(['data', 'links', 'meta']);

        $positions = $response->json('data.*.position');
        expect($positions)->toBe([3, 2]);
    });

    it('deve ser capaz de criar múltiplas fotos de anúncio de uma só vez', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $announcement = VehicleAnnouncement::factory()->create();

        $payload = [
            'vehicle_announcement_id' => $announcement->id,
            'photos' => [
                ['photo_url' => 'http://example.com/photo1.jpg', 'position' => 1],
                ['photo_url' => 'http://example.com/photo2.jpg', 'position' => 2],
            ],
        ];

        $response = $this->postJson('/api/announcement-photos', $payload);

        $response->assertStatus(201)
            ->assertJsonCount(2);

        $this->assertDatabaseHas('announcement_photos', ['position' => 1]);
        $this->assertDatabaseHas('announcement_photos', ['position' => 2]);
    });

    it('não deve criar fotos com posições duplicadas na mesma requisição', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $announcement = VehicleAnnouncement::factory()->create();

        $payload = [
            'vehicle_announcement_id' => $announcement->id,
            'photos' => [
                ['photo_url' => 'http://example.com/photo1.jpg', 'position' => 1],
                ['photo_url' => 'http://example.com/photo2.jpg', 'position' => 1],
            ],
        ];

        $response = $this->postJson('/api/announcement-photos', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('photos');
    });

    it('deve trocar as posições ao atualizar uma foto para uma posição já existente', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $announcement = VehicleAnnouncement::factory()->create();
        $photoA = AnnouncementPhoto::factory()->create(['vehicle_announcement_id' => $announcement->id, 'position' => 1]);
        $photoB = AnnouncementPhoto::factory()->create(['vehicle_announcement_id' => $announcement->id, 'position' => 2]);

        $response = $this->putJson("/api/announcement-photos/{$photoA->id}", ['position' => 2]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('announcement_photos', ['id' => $photoA->id, 'position' => 2]);
        $this->assertDatabaseHas('announcement_photos', ['id' => $photoB->id, 'position' => 1]);
    });

    it('deve reordenar as fotos subsequentes quando uma foto é deletada', function () {
        $user = User::all()->first();
        Sanctum::actingAs($user);
        $announcement = VehicleAnnouncement::factory()->create();
        $photo1 = AnnouncementPhoto::factory()->create(['vehicle_announcement_id' => $announcement->id, 'position' => 1]);
        $photo2 = AnnouncementPhoto::factory()->create(['vehicle_announcement_id' => $announcement->id, 'position' => 2]);
        $photo3 = AnnouncementPhoto::factory()->create(['vehicle_announcement_id' => $announcement->id, 'position' => 3]);

        $response = $this->deleteJson("/api/announcement-photos/{$photo2->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('announcement_photos', ['id' => $photo2->id]);
        $this->assertDatabaseHas('announcement_photos', ['id' => $photo1->id, 'position' => 1]);
        $this->assertDatabaseHas('announcement_photos', ['id' => $photo3->id, 'position' => 2]);
    });

});
