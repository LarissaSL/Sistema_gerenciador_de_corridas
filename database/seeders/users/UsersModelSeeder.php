<?php

namespace Database\Seeders\users;

use App\Models\users\UsersModel;
use Illuminate\Database\Seeder;

class UsersModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criando 10 usuários
        UsersModel::factory()->count(1000)->create();    
    }
}
