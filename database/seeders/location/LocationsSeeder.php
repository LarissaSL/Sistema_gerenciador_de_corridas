<?php

namespace Database\Seeders\location;

use App\Models\location\LocationsModel;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LocationsModel::create([
            'administrator_id' => 1,
            'name' => 'Kartódromo Central',
            'street' => 'Av. da Corrida',
            'number' => '100',
            'neighborhood' => 'Centro',
            'cep' => '12345000',
            'state' => 'SP',
            'status' => 1
        ]);

        LocationsModel::create([
            'administrator_id' => 1,
            'name' => 'Speed Arena',
            'street' => 'Rua da Aventura',
            'number' => '45',
            'neighborhood' => 'Racing Ville',
            'cep' => '54321000',
            'state' => 'RJ',
            'status' => 1
        ]);
    }
}
