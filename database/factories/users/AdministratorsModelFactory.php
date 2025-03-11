<?php

namespace Database\Factories\users;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdministratorsModelFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\users\UsersModel::factory(),
        ];
    }
}
