<?php

namespace Database\Seeders\races;

use App\Models\races\RacesModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = DB::table('locations')->pluck('id')->toArray();
        $onlineLocations = DB::table('online_location')->pluck('id')->toArray();
        $championships = DB::table('championships')->pluck('id')->toArray();

        for ($i = 1; $i <= 20; $i++) {
            $isPresencial = rand(0, 1);
            $location_id = $isPresencial ? $locations[array_rand($locations)] : null;
            $online_location_id = !$isPresencial ? $onlineLocations[array_rand($onlineLocations)] : null;

            RacesModel::create([
                'administrator_id' => 1,
                'location_id' => $location_id,
                'online_location_id' => $online_location_id,
                'championship_id' => rand(0, 1) ? $championships[array_rand($championships)] : null,
                'name' => "Corrida $i",
                'date' => Carbon::create(2024, 11)->addDays(rand(0, 400)),
                'time' => now()->format('H:i:s'),
                'category' => 'Livre',
                'price' => rand(100, 250),
                'status' => 1
            ]);
        }
    }
}
