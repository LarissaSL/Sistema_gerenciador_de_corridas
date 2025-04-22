<?php

namespace Database\Seeders\championship;

use App\Models\championships\ChampionshipsModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChampionshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            ChampionshipsModel::create([
                'administrator_id' => 1,
                'name' => "Campeonato {$i}",
                'acronym' => "C{$i}",
                'start_date' => Carbon::now()->addMonths($i),
                'final_date' => Carbon::now()->addMonths($i + 3),
                'status' => 1
            ]);
        }
    }
}
