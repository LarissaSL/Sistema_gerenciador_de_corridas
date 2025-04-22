<?php

namespace Database\Seeders\inscriptions;

use App\Models\inscriptions\InscriptionsModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $races = DB::table('races')->pluck('id')->toArray();

        foreach ($races as $race_id) {
            $qtd = rand(5, 20);
            $user_ids = collect(range(21, 1021))->random($qtd);

            foreach ($user_ids as $user_id) {
                InscriptionsModel::create([
                    'race_id' => $race_id,
                    'user_id' => $user_id,
                    'payment_status' => ['Confirmado', 'Cancelado', 'Em processamento', 'Reembolsado'][rand(0, 2)],
                    'payment_method' => [0, 1, 2][rand(0, 2)],
                    'status' => 1
                ]);
            }
        }
    }
}
