<?php

namespace App\Console\Commands;

use App\Models\AnnouncementPhoto;
use App\Models\Vehicle;
use App\Models\VehicleAnnouncement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportVehicleData extends Command
{
    protected $signature = 'vehicle:import-data';

    protected $description = 'Insere os dados dos veiculos baseado em um arquivo json.';

    public function handle()
    {
        $url = 'https://hub.alpes.one/api/v1/integrator/export/1902';

        try {
            $response = Http::get($url)->throw();
            $jsonData = $response->json();

            DB::transaction(function () use ($jsonData) {

                foreach ($jsonData as $data) {
                    $vehicle = Vehicle::firstOrNew([
                        'external_id' => $data['id'],
                    ]);
                    $vehicle->fill([
                        'type' => $data['type'],
                        'brand' => $data['brand'],
                        'model' => $data['model'],
                        'version' => $data['version'],
                        'year' => $data['year'],
                        'doors' => $data['doors'],
                        'board' => $data['board'],
                        'chassi' => $data['chassi'],
                        'transmission' => $data['transmission'],
                        'color' => $data['color'],
                        'fuel' => $data['fuel'],
                        'category' => $data['category'],
                    ]);
                    $vehicle->created_at = $data['created'];
                    $vehicle->updated_at = $data['updated'];
                    $vehicle->save();

                    $announcement = VehicleAnnouncement::firstOrNew([
                        'vehicle_id' => $vehicle->id,
                    ]);
                    $announcement->fill([
                        'description' => $data['description'],
                        'price' => $data['price'],
                        'old_price' => $data['old_price'],
                        'sold' => $data['sold'],
                        'url_car' => $data['url_car'],
                        'optionals' => $data['optionals'],
                    ]);
                    $announcement->created_at = $data['created'];
                    $announcement->updated_at = $data['updated'];
                    $announcement->save();

                    foreach ($data['fotos'] as $key => $photoUrl) {
                        $photo = AnnouncementPhoto::firstOrNew([
                            'vehicle_announcement_id' => $announcement->id,
                            'photo_url' => $photoUrl,
                        ]);
                        $photo->fill([
                            'position' => $key + 1,
                        ]);
                        $photo->created_at = $data['created'];
                        $photo->updated_at = $data['updated'];
                        $photo->save();
                    }
                }
            });

            $this->info('Dados importados com sucesso!');

        } catch (\Exception $e) {
            $this->error('Erro ao importar os dados: '.$e->getMessage());
        }
    }
}
