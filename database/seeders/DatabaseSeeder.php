<?php

namespace Database\Seeders;

use App\Models\users\AdministratorsModel;
use App\Models\users\UsersModel;
use Database\Seeders\championship\ChampionshipsSeeder;
use Database\Seeders\inscriptions\InscriptionsSeeder;
use Database\Seeders\location\LocationsSeeder;
use Database\Seeders\onlineLocation\OnlineLocationsSeeder;
use Database\Seeders\races\RacesSeeder;
use Database\Seeders\users\UsersModelSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UsersModelSeeder::class,
        ]);

        $this->call([
            LocationsSeeder::class,
            OnlineLocationsSeeder::class,
            ChampionshipsSeeder::class,
            RacesSeeder::class,
            InscriptionsSeeder::class,
        ]);

        // Criar o usuário Larissa
        $larissa = UsersModel::factory()->create([
            'email' => 'larissa.silvaedge@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        // Criar o usuário Giuliana
        $giuliana = UsersModel::factory()->create([
            'email' => 'usocomumapps@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        AdministratorsModel::factory()->create([
            'user_id' => $larissa->id,
        ]);

        AdministratorsModel::factory()->create([
            'user_id' => $giuliana->id,
        ]);
    }
}
