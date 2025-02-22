<?php

namespace Database\Seeders;

use Database\Seeders\users\UsersModelSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    }
}
