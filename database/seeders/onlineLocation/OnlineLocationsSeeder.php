<?php

namespace Database\Seeders\onlineLocation;

use App\Models\location\OnlineLocationModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OnlineLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 2; $i++) {
            OnlineLocationModel::create([
                'administrator_id' => 1,
                'link' => "https://corridaonline{$i}.com/sala",
                'room' => "Sala {$i}",
                'room_password' => "senha{$i}"
            ]);
        }
    }
}
